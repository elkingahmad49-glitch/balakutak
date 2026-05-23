<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"));

        $tags = $query->latest()->paginate(15)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'description' => 'nullable|string',
        ]);

        Tag::create([
            ...$validated,
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil ditambahkan!');
    }

    public function show(Tag $tag)
    {
        return redirect()->route('admin.tags.edit', $tag);
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string',
        ]);

        $tag->update([
            ...$validated,
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui!');
    }

    public function destroy(Tag $tag)
    {
        if ($tag->posts()->exists()) {
            return back()->with('error', 'Tag tidak dapat dihapus karena masih digunakan pada artikel!');
        }

        $tag->delete();
        return back()->with('success', 'Tag berhasil dihapus!');
    }
}
