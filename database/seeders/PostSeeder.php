<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id ?? 1;
        $categoryId = Category::firstOrCreate([
            'name' => 'Berita & Informasi',
            'slug' => 'berita-informasi'
        ])->id;

        $posts = [
            [
                'title' => 'Program Studi Raih Akreditasi Unggul Tahun 2026',
                'excerpt' => 'Program studi secara resmi mendapatkan peringkat akreditasi tertinggi "Unggul" dari lembaga akreditasi nasional.',
                'content' => '<p>Prestasi membanggakan kembali diraih oleh Program Studi. Setelah melalui serangkaian asesmen lapangan yang ketat oleh tim asesor, lembaga akreditasi nasional menetapkan bahwa Program Studi berhak mendapatkan predikat <strong>Unggul</strong>. Pencapaian ini merupakan hasil kerja keras seluruh dosen, staf, mahasiswa, dan alumni dalam menjaga mutu akademik secara konsisten.</p>',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Dosen Prodi Kembangkan IoT untuk Pertanian Modern',
                'excerpt' => 'Tim riset dosen prodi berhasil mempublikasikan karya teknologi IoT yang membantu efisiensi irigasi sawah.',
                'content' => '<p>Dalam upaya mendukung kedaulatan pangan dan digitalisasi sektor agraris, tim dosen Program Studi berhasil meluncurkan sistem irigasi berbasis Internet of Things (IoT). Alat ini memungkinkan petani mengontrol kelembaban tanah dan mendistribusikan air secara otomatis lewat smartphone. Hasil penelitian ini juga telah dipublikasikan di jurnal internasional bereputasi.</p>',
                'type' => 'post',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Mahasiswa Prodi Menangkan Juara 1 Lomba Hackathon Nasional',
                'excerpt' => 'Tim mahasiswa berhasil merebut medali emas dalam kompetisi hackathon nasional berkat inovasi aplikasi kesehatan.',
                'content' => '<p>Tiga mahasiswa Program Studi angkatan 2023 sukses meraih juara pertama di ajang Hackathon Nasional yang diselenggarakan oleh Asosiasi Industri Teknologi. Tim bernama "BalaKutaK Tech" ini mengusung aplikasi inovasi telemedisin terintegrasi dengan kecerdasan buatan untuk diagnosa dini penyakit jantung bawaan, mengalahkan lebih dari 100 tim pesaing dari perguruan tinggi lain.</p>',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Pentingnya Mempelajari Framework Modern Sejak Kuliah',
                'excerpt' => 'Artikel opini membahas relevansi pemahaman framework pemrograman (Laravel, React) bagi kesiapan kerja lulusan.',
                'content' => '<p>Di era industri digital yang dinamis, kemampuan menulis kode vanilla tidak lagi cukup. Pemahaman mendalam mengenai framework modern seperti Laravel, NestJS, atau React merupakan modal utama agar lulusan cepat terserap di industri software house maupun korporat skala besar. Mata kuliah rekayasa perangkat lunak kini terus menyesuaikan silabus agar sejalan dengan kebutuhan tersebut.</p>',
                'type' => 'post',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Kolaborasi Riset Internasional antara Prodi dan Universitas Luar Negeri',
                'excerpt' => 'Kerjasama strategis penguatan riset bersama dibidang cyber security dan data analytics dengan universitas global.',
                'content' => '<p>Program studi terus memperluas jaringan internasional guna meningkatkan kualitas riset dosen dan mahasiswa. Ditandai dengan penandatanganan Memorandum of Agreement (MoA), Program Studi menyepakati kerjasama riset terapan di bidang keamanan siber (cyber security) dan analisis data besar (data analytics). Kerjasama ini mencakup pertukaran reviewer jurnal dan kolaborasi publikasi ilmiah global.</p>',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($posts as $data) {
            Post::create(array_merge($data, [
                'user_id' => $userId,
                'category_id' => $categoryId,
                'language' => 'id',
            ]));
        }
    }
}
