<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'PT Telekomunikasi Indonesia Tbk',
                'website_url' => 'https://telkom.co.id',
                'description' => 'Kerjasama program magang bersertifikat dan penyelarasan kurikulum bidang jaringan telekomunikasi.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Badan Siber dan Sandi Negara (BSSN)',
                'website_url' => 'https://bssn.go.id',
                'description' => 'Mitra kolaborasi pelatihan siber, kuliah tamu cyber security, dan pengujian kerentanan sistem.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'PT Bank Mandiri (Persero) Tbk',
                'website_url' => 'https://bankmandiri.co.id',
                'description' => 'Penyediaan beasiswa mahasiswa berprestasi, kerjasama riset finansial teknologi, dan rekrutmen alumni.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'PT Tokopedia',
                'website_url' => 'https://tokopedia.com',
                'description' => 'Kerjasama program bootcamp developer, riset bersama kecerdasan buatan, dan magang studi independen.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Microsoft Indonesia',
                'website_url' => 'https://microsoft.com/id-id',
                'description' => 'Program sertifikasi kompetensi cloud computing (Azure) dan lisensi akademik perangkat lunak pengembang.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $data) {
            Partner::create($data);
        }
    }
}
