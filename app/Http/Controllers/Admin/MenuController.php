<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

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
     */
    public function saveItems(Request $request, Menu $menu)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        // Clear existing items to recreate them from the builder
        // Or realistically, just iterate and update them, but usually 
        // a simple builder sends the entire list back and recreating is easier 
        // if IDs aren't strictly preserved, but let's assume it sends standard properties.

        // Simpler approach for a nestable builder array:
        $menu->allItems()->delete();

        $order = 0;
        foreach ($request->items as $item) {
            $this->createMenuItem($menu->id, null, $item, $order);
            $order++;
        }

        return response()->json(['success' => true, 'message' => 'Susunan menu berhasil disimpan.']);
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
