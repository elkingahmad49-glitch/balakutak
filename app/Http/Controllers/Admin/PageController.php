<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class PageController extends Controller
{
    use \App\Traits\HasMedia;
    public function index(Request $request)
    {
        $query = \App\Models\Page::query()
            ->with('user')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status === 'published', fn($q) => $q->where('is_published', true))
            ->when($request->status === 'draft', fn($q) => $q->where('is_published', false));

        $pages = $query->orderBy('title', 'asc')->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function builderIndex(Request $request)
    {
        $query = \App\Models\Page::query()
            ->with('user')
            ->where('is_builder', true)
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status === 'published', fn($q) => $q->where('is_published', true))
            ->when($request->status === 'draft', fn($q) => $q->where('is_published', false));

        $pages = $query->orderBy('title', 'asc')->paginate(15)->withQueryString();

        return view('admin.pages.builder_index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => $request->boolean('is_builder') ? 'nullable|string' : 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'is_published' => 'boolean',
            'is_builder' => 'boolean',
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['title']);
        $i = 1;
        while (\App\Models\Page::where('slug', $slug)->exists()) {
            $slug = \Illuminate\Support\Str::slug($validated['title']) . '-' . $i++;
        }

        $page = new \App\Models\Page();
        $page->user_id = auth()->id();
        $page->title = $validated['title'];
        $page->slug = $slug;
        $page->content = $validated['content'] ?? '';
        $page->excerpt = $validated['excerpt'];
        $page->is_published = $request->boolean('is_published', true);
        $page->is_builder = $request->boolean('is_builder', false);

        // Handle Image via HasMedia logic
        $path = $this->handleMedia('featured_image', 'pages', $page->title);
        if ($path) {
            $page->featured_image = $path;

            $this->syncToGallery($page, $path, 'Halaman');
        }

        $page->save();

        if ($page->is_builder) {
            return redirect()->route('admin.pages.builder', $page)->with('success', 'Halaman berhasil dibuat! Sekarang silakan desain halaman Anda.');
        }

        return redirect()->route('admin.pages.index')->with('success', 'Halaman statis berhasil ditambahkan!');
    }

    public function edit(\App\Models\Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, \App\Models\Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => $request->boolean('is_builder') ? 'nullable|string' : 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:4096',
            'is_published' => 'boolean',
            'is_builder' => 'boolean',
        ]);

        // Handle Image via HasMedia logic
        $path = $this->handleMedia('featured_image', 'pages', $validated['title']);
        if ($path) {
            if ($page->featured_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($page->featured_image);
            }
            $page->featured_image = $path;

            $this->syncToGallery($page, $path, 'Halaman');
        }

        $page->title = $validated['title'];
        $page->content = $validated['content'] ?? $page->content;
        $page->excerpt = $validated['excerpt'];
        $page->is_published = $request->boolean('is_published', true);
        $page->is_builder = $request->boolean('is_builder', $page->is_builder);
        $page->save();

        if ($page->is_builder) {
            return redirect()->route('admin.pages.builder-index')->with('success', 'Halaman custom berhasil diperbarui!');
        }

        return redirect()->route('admin.pages.index')->with('success', 'Halaman statis berhasil diperbarui!');
    }

    public function destroy(\App\Models\Page $page)
    {
        if ($page->featured_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($page->featured_image);
        }
        $page->delete();

        return back()->with('success', 'Halaman statis berhasil dihapus!');
    }

    public function builder(\App\Models\Page $page)
    {
        if (!$page->is_builder) {
            return redirect()->route('admin.pages.edit', $page)->with('error', 'Halaman ini tidak menggunakan Page Builder.');
        }
        return view('admin.pages.builder', compact('page'));
    }

    public function saveBuilder(Request $request, \App\Models\Page $page)
    {
        $request->validate([
            'html' => 'required|string',
            'css' => 'required|string',
            'components' => 'required|string',
            'styles' => 'required|string',
        ]);

        $page->content = $request->html;
        $page->builder_data = json_encode([
            'components' => $request->components,
            'styles' => $request->styles,
            'css' => $request->css,
        ]);
        $page->save();

        return response()->json(['success' => true]);
    }
}
