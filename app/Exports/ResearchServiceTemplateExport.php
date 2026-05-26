<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class ResearchServiceTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return new Collection([
            [
                'Pengembangan Sistem AI untuk Diagnosa Medis',
                'Dr. Ir. Ahmad Yani, M.T.',
                '2025',
                'penelitian',
                'Abstrak penelitian ini membahas tentang rancangan sistem kecerdasan buatan dalam membantu dokter melakukan diagnosa penyakit.',
                'Deskripsi lengkap dari pengembangan sistem AI, metodologi yang digunakan, hasil akurasi model, dan implementasi pada rumah sakit.',
                'https://scholar.google.com/citations?user=sample1',
                '1'
            ],
            [
                'Pelatihan Digital Marketing untuk UMKM Desa Sukamaju',
                'Siti Aminah, M.M.',
                '2026',
                'pengabdian',
                'Kegiatan pengabdian ini bertujuan untuk meningkatkan literasi digital pemasaran bagi pelaku usaha mikro.',
                'Deskripsi kegiatan pengabdian meliputi persiapan materi, pelaksanaan workshop tatap muka, pendampingan pembuatan akun e-commerce, dan hasil evaluasi omset UMKM.',
                'https://sinta.kemdikbud.go.id/authors/profile/sample2',
                '2'
            ]
        ]);
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
            'Urutan'
        ];
    }

    public function title(): string
    {
        return 'Template Import Penelitian & Pengabdian';
    }
}
