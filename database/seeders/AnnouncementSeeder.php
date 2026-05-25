<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id ?? 1;

        $announcements = [
            [
                'title' => 'Pendaftaran Ujian Sidang Skripsi Gelombang II Tahun 2026',
                'content' => '<p>Diberitahukan kepada seluruh mahasiswa tingkat akhir bahwa pendaftaran Ujian Sidang Skripsi Gelombang II Tahun Akademik 2025/2026 telah dibuka mulai tanggal 1 Juni hingga 15 Juni 2026. Persyaratan administrasi dan pendaftaran online dapat diakses melalui portal akademik mahasiswa.</p>',
                'priority' => 'high',
                'is_published' => true,
                'expire_date' => '2026-06-16',
                'language' => 'id',
            ],
            [
                'title' => 'Pengumuman Pembagian Dosen Wali Semester Ganjil 2026/2027',
                'content' => '<p>Berikut disampaikan daftar pembagian Dosen Wali untuk mahasiswa angkatan 2023, 2024, dan 2025. Silakan berkonsultasi mengenai rencana studi Semester Ganjil 2026/2027 sebelum melakukan pengisian KRS online.</p>',
                'priority' => 'normal',
                'is_published' => true,
                'expire_date' => '2026-08-31',
                'language' => 'id',
            ],
            [
                'title' => 'Jadwal Pengisian KRS Online Mahasiswa Baru Angkatan 2026',
                'content' => '<p>Pengisian Kartu Rencana Studi (KRS) online bagi Mahasiswa Baru Angkatan 2026 akan dilaksanakan secara serentak pada tanggal 18 - 22 Agustus 2026 melalui sistem informasi akademik mahasiswa (SIAKAD).</p>',
                'priority' => 'urgent',
                'is_published' => true,
                'expire_date' => '2026-08-23',
                'language' => 'id',
            ],
            [
                'title' => 'Beasiswa Prestasi Akademik Program Studi Tahun 2026',
                'content' => '<p>Program Studi membuka kesempatan beasiswa prestasi akademik bagi mahasiswa aktif semester 3 hingga 7 yang memiliki IPK minimal 3.50. Batas akhir pengumpulan berkas fisik ke sekretariat prodi adalah 25 Juni 2026.</p>',
                'priority' => 'normal',
                'is_published' => true,
                'expire_date' => '2026-06-26',
                'language' => 'id',
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::create(array_merge($data, ['user_id' => $userId]));
        }
    }
}
