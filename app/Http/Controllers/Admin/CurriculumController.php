<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CurriculumImport;
use App\Exports\CurriculumTemplateExport;
use App\Exports\CurriculumsExport;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $query = Curriculum::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('code', 'like', "%{$request->search}%"))
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->type, fn($q) => $q->where('type', $request->type));

        $curriculums = $query->orderBy('semester')->orderBy('code')->paginate(20)->withQueryString();

        // Group by semester for potentially a better view or dropdown filter
        $semesters = Curriculum::select('semester')->distinct()->orderBy('semester')->pluck('semester');

        return view('admin.curriculums.index', compact('curriculums', 'semesters'));
    }

    public function create()
    {
        return view('admin.curriculums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'credits' => 'required|integer|min:0|max:10',
            'description' => 'nullable|string',
            'type' => 'required|in:wajib,pilihan',
            'concentration' => 'nullable|string|max:255',
            'rps_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $curriculum = new Curriculum($validated);

        if ($request->hasFile('rps_file')) {
            $curriculum->rps_file = $request->file('rps_file')->store('curriculum', 'public');
        }

        $curriculum->is_active = $request->boolean('is_active', true);
        $curriculum->save();

        return redirect()->route('admin.curriculums.index')->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function edit(Curriculum $curriculum)
    {
        return view('admin.curriculums.edit', compact('curriculum'));
    }

    public function update(Request $request, Curriculum $curriculum)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'credits' => 'required|integer|min:0|max:10',
            'description' => 'nullable|string',
            'type' => 'required|in:wajib,pilihan',
            'concentration' => 'nullable|string|max:255',
            'rps_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('rps_file')) {
            if ($curriculum->rps_file) {
                Storage::disk('public')->delete($curriculum->rps_file);
            }
            $validated['rps_file'] = $request->file('rps_file')->store('curriculum', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $curriculum->update($validated);

        return redirect()->route('admin.curriculums.index')->with('success', 'Mata kuliah berhasil diperbarui!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        try {
            Excel::import(new CurriculumImport, $request->file('file'));
            return redirect()->route('admin.curriculums.index')->with('success', 'Data kurikulum berhasil diimpor!');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMsg = 'Gagal mengimpor data. Cek baris berikut: ';
            foreach ($failures as $failure) {
                $errorMsg .= "Baris " . $failure->row() . ": " . implode(', ', $failure->errors()) . ". ";
            }
            return redirect()->route('admin.curriculums.index')->with('error', $errorMsg);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.curriculums.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new CurriculumTemplateExport, 'template_import_kurikulum.xlsx');
    }

    public function export()
    {
        return Excel::download(new CurriculumsExport, 'data_kurikulum.xlsx');
    }

    public function destroy(Curriculum $curriculum)
    {
        if ($curriculum->rps_file) {
            Storage::disk('public')->delete($curriculum->rps_file);
        }
        $curriculum->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus!');
    }
}
