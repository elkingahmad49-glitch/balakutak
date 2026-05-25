<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Copy seed images to public storage
        $this->ensureSeedAssets();

        $userId = User::first()->id ?? 1;

        $events = [
            [
                'title' => 'Seminar Nasional Tren Teknologi AI di Industri 2026',
                'description' => 'Seminar nasional membahas implementasi Artificial Intelligence terkini di dunia industri kreatif.',
                'content' => '<p>Ikuti seminar nasional yang menghadirkan pembicara ahli dari praktisi AI industri terkemuka. Acara ini terbuka untuk mahasiswa umum dan praktisi IT.</p>',
                'featured_image' => 'events/ai_seminar.png',
                'location' => 'Aula Gedung Utama Lantai 3',
                'start_date' => now()->addDays(7)->format('Y-m-d 09:00:00'),
                'end_date' => now()->addDays(7)->format('Y-m-d 13:00:00'),
                'registration_deadline' => now()->addDays(6)->format('Y-m-d 23:59:59'),
                'max_participants' => 200,
                'is_published' => true,
                'is_free' => true,
                'category' => 'Seminar',
                'organizer' => 'Himpunan Mahasiswa Program Studi',
                'contact_person' => 'Budi (+62 812-3456-7890)',
            ],
            [
                'title' => 'Workshop UI/UX Design & User Research',
                'description' => 'Workshop intensif merancang antarmuka pengguna digital yang modern dan berorientasi pengguna.',
                'content' => '<p>Pelatihan langsung (hands-on) tentang teknik wireframing, prototyping, dan usability testing menggunakan Figma.</p>',
                'featured_image' => 'events/uiux.png',
                'location' => 'Lab Komputer Rekayasa Perangkat Lunak',
                'start_date' => now()->addDays(14)->format('Y-m-d 08:30:00'),
                'end_date' => now()->addDays(14)->format('Y-m-d 16:00:00'),
                'registration_deadline' => now()->addDays(12)->format('Y-m-d 23:59:59'),
                'max_participants' => 40,
                'is_published' => true,
                'is_free' => false,
                'price' => 50000.00,
                'category' => 'Workshop',
                'organizer' => 'Program Studi',
                'contact_person' => 'Siti (+62 813-9876-5432)',
            ],
            [
                'title' => 'Webinar Karir: Menjadi Full-Stack Developer Kompeten',
                'description' => 'Webinar karir seputar skill set penting yang dibutuhkan industri teknologi masa kini.',
                'content' => '<p>Berdiskusi langsung dengan software engineer berpengalaman mengenai peta jalan karir dan teknologi penting (React, Node.js, Laravel).</p>',
                'featured_image' => 'events/fullstack.png',
                'location' => 'Zoom Meeting & Live YouTube',
                'online_url' => 'https://zoom.us/j/examplewebinar',
                'start_date' => now()->addDays(3)->format('Y-m-d 14:00:00'),
                'end_date' => now()->addDays(3)->format('Y-m-d 16:00:00'),
                'registration_deadline' => now()->addDays(2)->format('Y-m-d 18:00:00'),
                'max_participants' => 500,
                'is_published' => true,
                'is_free' => true,
                'category' => 'Webinar',
                'organizer' => 'Alumni Network & Career Center',
                'contact_person' => 'Rian (+62 815-5555-4444)',
            ],
            [
                'title' => 'Lomba Coding & Hackathon BalaKutaK 2026',
                'description' => 'Ajang kompetisi pemrograman dan pemecahan masalah cepat tingkat nasional.',
                'content' => '<p>Tantang kemampuan coding tim Anda dalam ajang hackathon 24 jam untuk memecahkan kasus riil dari mitra industri.</p>',
                'featured_image' => 'events/coding_contest.png',
                'location' => 'Gedung Rektorat Lantai 2',
                'start_date' => now()->addDays(25)->format('Y-m-d 08:00:00'),
                'end_date' => now()->addDays(26)->format('Y-m-d 17:00:00'),
                'registration_deadline' => now()->addDays(20)->format('Y-m-d 23:59:59'),
                'max_participants' => 30,
                'is_published' => true,
                'is_free' => false,
                'price' => 150000.00,
                'category' => 'Kompetisi',
                'organizer' => 'Program Studi & Himpunan',
                'contact_person' => 'Dian (+62 811-2222-3333)',
            ],
        ];

        foreach ($events as $data) {
            Event::create(array_merge($data, ['user_id' => $userId]));
        }
    }

    private function ensureSeedAssets()
    {
        $assetPath = database_path('seeders/assets/events');
        if (File::exists($assetPath)) {
            if (!Storage::disk('public')->exists('events')) {
                Storage::disk('public')->makeDirectory('events');
            }
            $files = File::files($assetPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                Storage::disk('public')->put("events/$filename", File::get($file->getRealPath()));
            }
        }
    }
}
