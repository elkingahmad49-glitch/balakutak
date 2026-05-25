<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Budi Santoso, S.Kom.',
                'position' => 'Senior Software Engineer',
                'company' => 'PT GoTo Gojek Tokopedia Tbk',
                'content' => 'Kurikulum di Program Studi sangat relevan dengan kebutuhan industri software engineering modern saat ini. Dosen-dosennya tidak hanya kompeten secara teori tetapi juga berpengalaman praktis. Proyek perkuliahan berbasis tim melatih saya beradaptasi cepat di lingkungan kerja kolaboratif.',
                'rating' => 5,
                'batch_year' => '2019',
                'is_approved' => true,
                'language' => 'id',
            ],
            [
                'name' => 'Siti Aminah, S.Kom.',
                'position' => 'Lead UI/UX Designer',
                'company' => 'Shopee Indonesia',
                'content' => 'Dukungan fasilitas lab komputer yang canggih dan kebebasan mengeksplorasi minat pribadi sangat membantu saya mendalami dunia UI/UX design. Hubungan dosen dan mahasiswa yang sangat bersahabat membuat iklim belajar menjadi nyaman, kondusif, dan produktif.',
                'rating' => 5,
                'batch_year' => '2020',
                'is_approved' => true,
                'language' => 'id',
            ],
            [
                'name' => 'Rian Hidayat, S.Kom.',
                'position' => 'Cyber Security Analyst',
                'company' => 'Badan Siber dan Sandi Negara (BSSN)',
                'content' => 'Konsentrasi keamanan jaringan dan siber di program studi ini sangat mendalam. Keterlibatan saya dalam berbagai proyek riset dosen membantu mengasah keahlian analisis forensik digital dan manajemen risiko keamanan informasi sebelum saya resmi lulus.',
                'rating' => 4,
                'batch_year' => '2018',
                'is_approved' => true,
                'language' => 'id',
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }
}
