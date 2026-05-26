<?php

namespace App\Exports;

use App\Models\ResearchService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResearchServicesExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return ResearchService::orderBy('order')->orderBy('year', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Peneliti / Pelaksana',
            'Tahun',
            'Tipe (penelitian/pengabdian)',
            'Abstrak',
            'Deskripsi',
            'Link Eksternal',
            'Status Aktif',
            'Urutan'
        ];
    }

    public function map($researchService): array
    {
        return [
            $researchService->title,
            $researchService->author,
            $researchService->year,
            $researchService->type === 'research' ? 'penelitian' : 'pengabdian',
            $researchService->abstract,
            $researchService->content,
            $researchService->external_link,
            $researchService->is_active ? 'Aktif' : 'Nonaktif',
            $researchService->order
        ];
    }

    public function title(): string
    {
        return 'Data Penelitian & Pengabdian';
    }
}
