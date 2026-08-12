<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::withCount('items')->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:top-menu,main-menu,secondary-menu,footer-menu|unique:menus',
            'is_active' => 'boolean',
        ]);

        Menu::create([
            'name' => $request->name,
            'location' => $request->location,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Often used as the "Builder" interface for menu items.
     */
    public function show(Menu $menu)
    {
        $menu->load(['items.children' => function ($q) {
            $q->orderBy('order');
        }]);

        $pages = \App\Models\Page::select('id', 'title', 'slug')->get();

        // Dynamic System Pages
        $dynamicPages = [
            ['title' => 'Beranda', 'url' => '/'],
            ['title' => 'Detail Profil', 'url' => '/tentang'],
            ['title' => 'Pendidikan', 'url' => '/akademik'],
            ['title' => 'Kurikulum', 'url' => '/kurikulum'],
            ['title' => 'Kalender Akademik', 'url' => '/kalender-akademik'],
            ['title' => 'Sistem & Layanan', 'url' => '/academic-services'],
            ['title' => 'Penelitian', 'url' => '/penelitian'],
            ['title' => 'Pengabdian Masyarakat', 'url' => '/pengabdian'],
            ['title' => 'Dosen & SDM', 'url' => '/dosen'],
            ['title' => 'Berita / Artikel', 'url' => '/berita'],
            ['title' => 'Agenda / Event', 'url' => '/agenda'],
            ['title' => 'Galleri Foto', 'url' => '/galeri'],
            ['title' => 'Prosedur & Form', 'url' => '/dokumen'],
            ['title' => 'FAQs', 'url' => '/faqs'],
            ['title' => 'Kontak', 'url' => '/kontak'],
        ];

        return view('admin.menus.builder', compact('menu', 'pages', 'dynamicPages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:top-menu,main-menu,secondary-menu,footer-menu|unique:menus,location,' . $menu->id,
            'is_active' => 'boolean',
        ]);

        $menu->update([
            'name' => $request->name,
            'location' => $request->location,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->allItems()->delete(); // cascade delete items
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Save the order and hierarchy of menu items.
     *
     * Three layers of protection here:
     *  1. Idempotency guard - if the exact same payload arrives again within
     *     a few seconds (classic double-submit / double request), the second
     *     one is dropped instantly before touching the DB at all.
     *  2. DB transaction + row lock - overlapping requests for the same menu
     *     queue up instead of racing each other.
     *  3. Payload-level dedupe - even if the incoming `items` array itself
     *     already contains duplicate entries (same label+url+parent), only
     *     the first occurrence at each level is kept before saving.
     */
    public function saveItems(Request $request, Menu $menu)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        // --- Layer 1: idempotency guard against double requests ---
        $payloadHash = md5($menu->id . json_encode($request->items));
        $cacheKey = "menu-save-lock:{$menu->id}:{$payloadHash}";

        if (Cache::has($cacheKey)) {
            // Identical save already processed a moment ago - ignore this repeat.
            return response()->json([
                'success' => true,
                'message' => 'Susunan menu berhasil disimpan.',
            ]);
        }
        Cache::put($cacheKey, true, now()->addSeconds(10));

        // --- Layer 3: dedupe the incoming array itself before saving ---
        $cleanItems = $this->dedupeItems($request->items);

        DB::transaction(function () use ($cleanItems, $menu) {
            // --- Layer 2: lock the menu row so overlapping requests queue up ---
            $lockedMenu = Menu::whereKey($menu->id)->lockForUpdate()->firstOrFail();

            $lockedMenu->allItems()->delete();

            $order = 0;
            foreach ($cleanItems as $item) {
                $this->createMenuItem($lockedMenu->id, null, $item, $order);
                $order++;
            }
        });

        return response()->json(['success' => true, 'message' => 'Susunan menu berhasil disimpan.']);
    }

    /**
     * Recursively strip duplicate entries (same label + url) at each level
     * of the nested items array, keeping only the first occurrence.
     */
    private function dedupeItems(array $items): array
    {
        $seen = [];
        $result = [];

        foreach ($items as $item) {
            $key = ($item['label'] ?? '') . '|' . ($item['url'] ?? '');

            if (isset($seen[$key])) {
                continue; // skip duplicate
            }
            $seen[$key] = true;

            if (!empty($item['children'])) {
                $item['children'] = $this->dedupeItems($item['children']);
            }

            $result[] = $item;
        }

        return $result;
    }

    private function createMenuItem($menuId, $parentId, $data, $order)
    {
        $menuItem = MenuItem::create([
            'menu_id' => $menuId,
            'parent_id' => $parentId,
            'label' => $data['label'] ?? 'Link',
            'url' => $data['url'] ?? null,
            'icon' => $data['icon'] ?? null,
            'target' => $data['target'] ?? '_self',
            'order' => $order,
        ]);

        if (!empty($data['children'])) {
            $childOrder = 0;
            foreach ($data['children'] as $child) {
                $this->createMenuItem($menuId, $menuItem->id, $child, $childOrder);
                $childOrder++;
            }
        }
    }
}