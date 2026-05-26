<?php

namespace App\Exports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class CurriculumsExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return Curriculum::orderBy('order')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Semester',
            'SKS',
            'Deskripsi',
            'Tipe',
            'Konsentrasi',
            'Status Aktif',
            'Urutan'
        ];
    }

    public function map($curriculum): array
    {
        return [
            $curriculum->code,
            $curriculum->name,
            $curriculum->semester,
            $curriculum->credits,
            $curriculum->description,
            $curriculum->type,
            $curriculum->concentration,
            $curriculum->is_active ? 'Aktif' : 'Nonaktif',
            $curriculum->order
        ];
    }

    public function title(): string
    {
        return 'Data Kurikulum';
    }
}
