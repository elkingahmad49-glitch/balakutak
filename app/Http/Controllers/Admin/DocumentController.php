<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['user', 'category'])
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('document_category_id', $request->category));

        $documents = $query->latest()->paginate(15)->withQueryString();

        $categories = DocumentCategory::orderBy('name')->get();

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|max:30720', // max 30MB
            'language' => 'nullable|in:id,en',
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');

        $document = new Document();
        $document->user_id = Auth::id();
        $document->title = $validated['title'];
        $document->description = $validated['description'];
        $document->document_category_id = $validated['document_category_id'];
        $document->language = $validated['language'] ?? app()->getLocale();
        $document->is_public = $request->boolean('is_public', true);

        // File details
        $document->file_name = $file->getClientOriginalName();
        $document->file_type = $file->getClientOriginalExtension() ?: 'unknown';
        $document->file_size = $file->getSize();
        $document->file_path = $file->store('documents', 'public');

        $document->save();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function edit(Document $document)
    {
        $categories = DocumentCategory::orderBy('name')->get();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'nullable|file|max:30720',
            'language' => 'nullable|in:id,en',
            'is_public' => 'boolean',
        ]);

        $document->title = $validated['title'];
        $document->description = $validated['description'];
        $document->document_category_id = $validated['document_category_id'];
        $document->language = $validated['language'] ?? $document->language;
        $document->is_public = $request->boolean('is_public', true);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $document->file_name = $file->getClientOriginalName();
            $document->file_type = $file->getClientOriginalExtension() ?: 'unknown';
            $document->file_size = $file->getSize();
            $document->file_path = $file->store('documents', 'public');
        }

        $document->save();

        return redirect()->route('admin.documents.index')->with('success', 'Informasi dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus!');
    }

    public function download(Document $document)
    {
        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        $document->increment('download_count');
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function publicDownload($id)
    {
        $document = Document::where('is_public', true)->findOrFail($id);
        
        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        $document->increment('download_count');
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
