<?php

namespace App\Exports;

use App\Models\Lecturer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class LecturersExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return Lecturer::orderBy('order')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIP',
            'NIDN',
            'Tipe (dosen/tendik)',
            'Jabatan Akademik',
            'Jabatan Struktural',
            'Jabatan Umum',
            'Keahlian',
            'Pendidikan',
            'Email',
            'Phone',
            'Google Scholar URL',
            'SINTA URL',
            'Garuda URL',
            'LinkedIn URL',
            'Website URL',
            'Biografi',
            'Status Aktif',
            'Urutan'
        ];
    }

    public function map($lecturer): array
    {
        return [
            $lecturer->name,
            $lecturer->nip,
            $lecturer->nidn,
            $lecturer->type,
            $lecturer->academic_title,
            $lecturer->functional_position,
            $lecturer->position,
            $lecturer->expertise,
            $lecturer->education,
            $lecturer->email,
            $lecturer->phone,
            $lecturer->google_scholar_url,
            $lecturer->sinta_url,
            $lecturer->garuda_url,
            $lecturer->linkedin_url,
            $lecturer->website_url,
            $lecturer->biography,
            $lecturer->is_active ? 'Aktif' : 'Nonaktif',
            $lecturer->order
        ];
    }

    public function title(): string
    {
        return 'Data Dosen & Staff';
    }
}
