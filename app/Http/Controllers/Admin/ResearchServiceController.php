<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchService;
use App\Models\Media;
use App\Traits\HasMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ResearchServiceController extends Controller
{
    use HasMedia;

    public function index(Request $request)
    {
        $query = ResearchService::query()
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%")
                                                 ->orWhere('author', 'like', "%{$request->search}%"))
            ->when($request->type, fn($q) => $q->where('type', $request->type));

        $data = $query->orderBy('year', 'desc')->latest()->paginate(15)->withQueryString();

        return view('admin.research_services.index', compact('data'));
    }

    public function create()
    {
        return view('admin.research_services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'type' => 'required|in:research,community_service',
            'abstract' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'external_link' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
            'language' => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('file_path')) {
            $request->validate(['file_path' => 'file|max:30720']);
            $validated['file_path'] = $request->file('file_path')->store('research_files', 'public');
        }

        $validated['slug'] = Str::slug($request->title);
        $validated['is_active'] = $request->boolean('is_active', true);

        $research = ResearchService::create($validated);

        // Handle Image via HasMedia logic
        $path = $this->handleMedia('featured_image', 'research', $research->title);
        if ($path) {
            $research->update(['featured_image' => $path]);
            $this->syncToGallery($research, $path, 'Riset & Pengabdian');
        }

        return redirect()->route('admin.research-services.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(ResearchService $researchService)
    {
        return view('admin.research_services.edit', compact('researchService'));
    }

    public function update(Request $request, ResearchService $researchService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'type' => 'required|in:research,community_service',
            'abstract' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'external_link' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
            'language' => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('file_path')) {
            $request->validate(['file_path' => 'file|max:30720']);
            if ($researchService->file_path) {
                Storage::disk('public')->delete($researchService->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('research_files', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $researchService->update($validated);

        // Handle Image via HasMedia logic
        $path = $this->handleMedia('featured_image', 'research', $researchService->title);
        if ($path) {
            $researchService->update(['featured_image' => $path]);
            $this->syncToGallery($researchService, $path, 'Riset & Pengabdian');
        }


        return redirect()->route('admin.research-services.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(ResearchService $researchService)
    {
        if ($researchService->file_path) {
            Storage::disk('public')->delete($researchService->file_path);
        }
        $researchService->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
}
