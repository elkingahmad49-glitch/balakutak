<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Copy seed assets to storage if they don't exist
        $this->ensureSeedAssets();

        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Selamat Datang di BalaKutaK CMS', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Website / Institusi'],
            ['key' => 'site_tagline', 'value' => 'BalaKutaK adalah sebuah Content Management System (CMS) berbasis open source yang dirancang untuk memberikan kemudahan, fleksibilitas, dan kebebasan dalam membangun serta mengelola website secara efisien. Dikembangkan dengan semangat kolaborasi dan keterbukaan, BalaKutaK hadir sebagai solusi bagi individu, institusi pendidikan, organisasi, hingga komunitas digital yang membutuhkan platform web yang ringan, adaptif, dan mudah dikembangkan.', 'group' => 'general', 'type' => 'textarea', 'label' => 'Tagline / Deskripsi Singkat'],
            ['key' => 'site_logo', 'value' => 'images/logo.png', 'group' => 'general', 'type' => 'image', 'label' => 'Logo Prodi'],
            ['key' => 'site_logo_white', 'value' => 'images/logo_white.png', 'group' => 'general', 'type' => 'image', 'label' => 'Logo Prodi (Putih)'],
            ['key' => 'site_favicon', 'value' => 'images/favicon.png', 'group' => 'general', 'type' => 'image', 'label' => 'Favicon'],
            ['key' => 'total_students', 'value' => '850', 'group' => 'academic', 'type' => 'text', 'label' => 'Jumlah Mahasiswa Aktif'],
            ['key' => 'total_alumni', 'value' => '2400', 'group' => 'academic', 'type' => 'text', 'label' => 'Jumlah Alumni'],
            ['key' => 'accreditation', 'value' => 'Unggul', 'group' => 'academic', 'type' => 'text', 'label' => 'Akreditasi'],

            // Contact
            ['key' => 'contact_address', 'value' => 'Jl. Raya Campus No. 1, Kota, Provinsi 12345', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Alamat'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234 5678', 'group' => 'contact', 'type' => 'text', 'label' => 'Telepon'],
            ['key' => 'contact_email', 'value' => 'prodi@university.ac.id', 'group' => 'contact', 'type' => 'text', 'label' => 'Email'],
            ['key' => 'contact_maps_embed', 'value' => '', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Google Maps Embed URL'],
            ['key' => 'contact_maps_url', 'value' => 'https://maps.google.com', 'group' => 'contact', 'type' => 'text', 'label' => 'Google Maps Link'],

            // Social Media
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'Facebook URL'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'Instagram URL'],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'Twitter/X URL'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'YouTube URL'],
            ['key' => 'social_linkedin', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'LinkedIn URL'],
            ['key' => 'social_tiktok', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'TikTok URL'],
            ['key' => 'social_whatsapp', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'WhatsApp Number / Link'],

            // SEO
            ['key' => 'seo_meta_description', 'value' => 'Website Resmi Program Studi - Universitas', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Meta Description Default'],
            ['key' => 'seo_keywords', 'value' => 'program studi, universitas, akademik', 'group' => 'seo', 'type' => 'text', 'label' => 'Keywords Default'],
            ['key' => 'google_analytics', 'value' => '', 'group' => 'seo', 'type' => 'text', 'label' => 'Google Analytics ID'],

            // Academic
            ['key' => 'vision', 'value' => 'Menjadi program studi yang unggul dan berdaya saing global dalam bidang teknologi informasi pada tahun 2035.', 'group' => 'academic', 'type' => 'textarea', 'label' => 'Visi'],
            ['key' => 'mission', 'value' => "1. Menyelenggarakan pendidikan berkualitas\n2. Mengembangkan penelitian inovatif\n3. Melaksanakan pengabdian masyarakat", 'group' => 'academic', 'type' => 'textarea', 'label' => 'Misi'],
            ['key' => 'greeting_text', 'value' => 'Selamat datang di Program Studi kami. Kami berkomitmen untuk menghasilkan lulusan yang kompeten dan berdaya saing global.', 'group' => 'academic', 'type' => 'textarea', 'label' => 'Sambutan Ketua Prodi'],
            ['key' => 'greeting_name', 'value' => 'Prof. Fulan bin Fulan, M.Kom.', 'group' => 'academic', 'type' => 'text', 'label' => 'Nama Ketua Prodi'],
            ['key' => 'greeting_position', 'value' => 'Ketua Program Studi', 'group' => 'academic', 'type' => 'text', 'label' => 'Jabatan Ketua Prodi'],
            ['key' => 'profile_video_url', 'value' => 'https://youtu.be/uWKHrHpA1nY', 'group' => 'academic', 'type' => 'text', 'label' => 'URL Video Profil (YouTube Embed)'],
            ['key' => 'about_institution', 'value' => 'BalaKutaK adalah sebuah Content Management System (CMS) berbasis open source yang dirancang untuk memberikan kemudahan, fleksibilitas, dan kebebasan dalam membangun serta mengelola website secara efisien. Dikembangkan dengan semangat kolaborasi dan keterbukaan, BalaKutaK hadir sebagai solusi bagi individu, institusi pendidikan, organisasi, hingga komunitas digital yang membutuhkan platform web yang ringan, adaptif, dan mudah dikembangkan.

Dengan arsitektur yang modular dan ramah pengembang, BalaKutaK memungkinkan pengguna untuk menyesuaikan fitur sesuai kebutuhan—mulai dari pengelolaan konten, manajemen pengguna, hingga integrasi dengan berbagai teknologi modern. Tidak hanya berfokus pada fungsionalitas, BalaKutaK juga mengedepankan pengalaman pengguna (user experience) yang intuitif, sehingga dapat digunakan baik oleh pemula maupun profesional.

Sebagai proyek open source, BalaKutaK membuka ruang kontribusi bagi siapa saja yang ingin berpartisipasi dalam pengembangan, peningkatan keamanan, maupun inovasi fitur. Hal ini menjadikan BalaKutaK bukan sekadar CMS, tetapi juga ekosistem kolaboratif yang terus berkembang.

            BalaKutaK hadir sebagai wujud komitmen untuk mendukung transformasi digital yang inklusif, khususnya dalam dunia pendidikan dan pengembangan teknologi berbasis komunitas.', 'group' => 'academic', 'type' => 'textarea', 'label' => 'Detail Institusi (Halaman Tentang)'],
            
            // Appearance & Layout Defaults
            ['key' => 'site_name_layout', 'value' => '2', 'group' => 'general', 'type' => 'select', 'label' => 'Tata Letak Nama Website'],
            ['key' => 'site_name_line1', 'value' => 'Selamat Datang', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Baris 1'],
            ['key' => 'site_name_line2', 'value' => 'BalaKutaK CMS', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Baris 2'],
            ['key' => 'site_theme', 'value' => 'aurora-glass-balakutak', 'group' => 'appearance', 'type' => 'select', 'label' => 'Tema Website'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                    'label' => $setting['label'],
                ]
            );
        }
    }

    private function ensureSeedAssets()
    {
        $assetPath = database_path('seeders/assets');
        
        if (File::exists($assetPath)) {
            // Logo images
            if (!Storage::disk('public')->exists('images')) {
                Storage::disk('public')->makeDirectory('images');
            }
            
            foreach (['logo.png', 'logo_white.png', 'favicon.png'] as $file) {
                if (File::exists("$assetPath/images/$file")) {
                    Storage::disk('public')->put("images/$file", File::get("$assetPath/images/$file"));
                }
            }
            
            // Sliders
            if (!Storage::disk('public')->exists('sliders')) {
                Storage::disk('public')->makeDirectory('sliders');
            }
            if (File::exists("$assetPath/sliders/default_slider.png")) {
                Storage::disk('public')->put("sliders/default_slider.png", File::get("$assetPath/sliders/default_slider.png"));
            }
        }
    }
}
