<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LecturersImport;
use App\Exports\LecturerTemplateExport;
use App\Exports\LecturersExport;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecturer::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->status === 'active', fn($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('is_active', false));

        $lecturers = $query->orderBy('order')->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('admin.lecturers.create');
    }

    public function store(Request $request)
    {
        $this->sanitizeUrls($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:lecturers,nip',
            'nidn' => 'nullable|string|max:50|unique:lecturers,nidn',
            'position' => 'nullable|string|max:255',
            'academic_title' => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'google_scholar_url' => 'nullable|url|max:255',
            'sinta_url' => 'nullable|url|max:255',
            'garuda_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'biography' => 'nullable|string',
            'type' => 'required|in:dosen,tendik',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        $lecturer = new Lecturer($validated);

        if ($request->hasFile('photo')) {
            $lecturer->photo = $request->file('photo')->store('lecturers', 'public');
        }

        $lecturer->is_active = $request->boolean('is_active', true);
        $lecturer->order = $validated['order'] ?? (Lecturer::where('type', $request->type)->max('order') + 1);
        $lecturer->save();

        return redirect()->route('admin.lecturers.index')->with('success', 'Data staff / dosen berhasil ditambahkan!');
    }

    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $this->sanitizeUrls($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:lecturers,nip,' . $lecturer->id,
            'nidn' => 'nullable|string|max:50|unique:lecturers,nidn,' . $lecturer->id,
            'position' => 'nullable|string|max:255',
            'academic_title' => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'google_scholar_url' => 'nullable|url|max:255',
            'sinta_url' => 'nullable|url|max:255',
            'garuda_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'biography' => 'nullable|string',
            'type' => 'required|in:dosen,tendik',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($lecturer->photo) {
                Storage::disk('public')->delete($lecturer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('lecturers', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? $lecturer->order;

        $lecturer->update($validated);

        return redirect()->route('admin.lecturers.index')->with('success', 'Data staff / dosen berhasil diperbarui!');
    }

    private function sanitizeUrls(Request $request)
    {
        $urlFields = [
            'google_scholar_url', 'sinta_url', 'garuda_url', 'linkedin_url', 'website_url'
        ];

        foreach ($urlFields as $field) {
            if ($request->filled($field)) {
                $value = $request->input($field);
                if (!preg_match('~^(?:f|ht)tps?://~i', $value)) {
                    $request->merge([$field => 'https://' . $value]);
                }
            }
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        try {
            Excel::import(new LecturersImport, $request->file('file'));
            return back()->with('success', 'Data dosen / staff berhasil diimpor!');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMsg = 'Gagal mengimpor data. Cek baris berikut: ';
            foreach ($failures as $failure) {
                $errorMsg .= "Baris " . $failure->row() . ": " . implode(', ', $failure->errors()) . ". ";
            }
            return back()->with('error', $errorMsg);
        }
        catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new LecturerTemplateExport, 'template_import_dosen_staff.xlsx');
    }

    public function export()
    {
        return Excel::download(new LecturersExport, 'data_dosen_staff.xlsx');
    }

    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->photo) {
            Storage::disk('public')->delete($lecturer->photo);
        }
        $lecturer->delete();

        return back()->with('success', 'Data staff / dosen berhasil dihapus!');
    }
}
