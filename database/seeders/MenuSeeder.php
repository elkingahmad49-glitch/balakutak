<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Top Menu
        $topMenu = Menu::updateOrCreate(
            ['location' => 'top-menu'],
            ['name' => 'Top Menu', 'is_active' => true]
        );
        $topMenu->allItems()->delete(); // Reset items to avoid duplicates on re-run

        $topItems = [
            ['label' => 'Portal Akademik', 'url' => 'https://academic.example.ac.id', 'icon' => 'fas fa-university', 'target' => '_blank', 'order' => 1],
            ['label' => 'E-Learning', 'url' => 'https://elearning.example.ac.id', 'icon' => 'fas fa-laptop-code', 'target' => '_blank', 'order' => 2],
            ['label' => 'Perpustakaan', 'url' => 'https://library.example.ac.id', 'icon' => 'fas fa-book', 'target' => '_blank', 'order' => 3],
        ];

        foreach ($topItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $topMenu->id, 'parent_id' => null]));
        }

        // 2. Main Menu
        $mainMenu = Menu::updateOrCreate(
            ['location' => 'main-menu'],
            ['name' => 'Main Menu', 'is_active' => true]
        );
        $mainMenu->allItems()->delete(); // Reset

        // We will seed the parent items first, then their children
        // Parent: Beranda
        $beranda = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Beranda',
            'url' => '/',
            'icon' => 'fas fa-home',
            'target' => '_self',
            'order' => 1,
        ]);

        // Parent: Profil
        $profil = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Profil',
            'url' => '#',
            'icon' => 'fas fa-user-graduation',
            'target' => '_self',
            'order' => 2,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $profil->id,
            'label' => 'Tentang Prodi',
            'url' => '/tentang',
            'icon' => 'fas fa-info-circle',
            'target' => '_self',
            'order' => 1,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $profil->id,
            'label' => 'Dosen & SDM',
            'url' => '/dosen',
            'icon' => 'fas fa-users',
            'target' => '_self',
            'order' => 2,
        ]);

        // Parent: Akademik
        $akademik = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Akademik',
            'url' => '#',
            'icon' => 'fas fa-graduation-cap',
            'target' => '_self',
            'order' => 3,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $akademik->id,
            'label' => 'Kurikulum',
            'url' => '/kurikulum',
            'icon' => 'fas fa-book-reader',
            'target' => '_self',
            'order' => 1,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $akademik->id,
            'label' => 'Kalender Akademik',
            'url' => '/kalender-akademik',
            'icon' => 'fas fa-calendar-alt',
            'target' => '_self',
            'order' => 2,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $akademik->id,
            'label' => 'Sistem & Layanan',
            'url' => '/academic-services',
            'icon' => 'fas fa-cogs',
            'target' => '_self',
            'order' => 3,
        ]);

        // Parent: Riset & Pengabdian
        $riset = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Riset & Pengabdian',
            'url' => '#',
            'icon' => 'fas fa-microscope',
            'target' => '_self',
            'order' => 4,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $riset->id,
            'label' => 'Penelitian',
            'url' => '/penelitian',
            'icon' => 'fas fa-search',
            'target' => '_self',
            'order' => 1,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $riset->id,
            'label' => 'Pengabdian Masyarakat',
            'url' => '/pengabdian',
            'icon' => 'fas fa-handshake',
            'target' => '_self',
            'order' => 2,
        ]);

        // Parent: Publikasi
        $publikasi = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Publikasi',
            'url' => '#',
            'icon' => 'fas fa-bullhorn',
            'target' => '_self',
            'order' => 5,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $publikasi->id,
            'label' => 'Berita & Artikel',
            'url' => '/berita',
            'icon' => 'fas fa-newspaper',
            'target' => '_self',
            'order' => 1,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $publikasi->id,
            'label' => 'Agenda & Kegiatan',
            'url' => '/agenda',
            'icon' => 'fas fa-calendar-day',
            'target' => '_self',
            'order' => 2,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $publikasi->id,
            'label' => 'Galeri Foto',
            'url' => '/galeri',
            'icon' => 'fas fa-images',
            'target' => '_self',
            'order' => 3,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $publikasi->id,
            'label' => 'Prosedur & Form',
            'url' => '/dokumen',
            'icon' => 'fas fa-file-download',
            'target' => '_self',
            'order' => 4,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $publikasi->id,
            'label' => 'FAQs',
            'url' => '/faqs',
            'icon' => 'fas fa-question-circle',
            'target' => '_self',
            'order' => 5,
        ]);

        // Parent: Kontak
        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'label' => 'Kontak',
            'url' => '/kontak',
            'icon' => 'fas fa-envelope',
            'target' => '_self',
            'order' => 6,
        ]);


        // 3. Secondary Menu
        $secondaryMenu = Menu::updateOrCreate(
            ['location' => 'secondary-menu'],
            ['name' => 'Secondary Menu', 'is_active' => true]
        );
        $secondaryMenu->allItems()->delete(); // Reset

        $secondaryItems = [
            ['label' => 'Kurikulum', 'url' => '/kurikulum', 'icon' => 'fas fa-book-reader', 'target' => '_self', 'order' => 1],
            ['label' => 'Kalender Akademik', 'url' => '/kalender-akademik', 'icon' => 'fas fa-calendar-alt', 'target' => '_self', 'order' => 2],
            ['label' => 'Sistem & Layanan', 'url' => '/academic-services', 'icon' => 'fas fa-cogs', 'target' => '_self', 'order' => 3],
            ['label' => 'Prosedur & Form', 'url' => '/dokumen', 'icon' => 'fas fa-file-download', 'target' => '_self', 'order' => 4],
            ['label' => 'FAQs', 'url' => '/faqs', 'icon' => 'fas fa-question-circle', 'target' => '_self', 'order' => 5],
        ];

        foreach ($secondaryItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $secondaryMenu->id, 'parent_id' => null]));
        }

        // 4. Footer Menu
        $footerMenu = Menu::updateOrCreate(
            ['location' => 'footer-menu'],
            ['name' => 'Footer Menu', 'is_active' => true]
        );
        $footerMenu->allItems()->delete(); // Reset

        $footerItems = [
            ['label' => 'Beranda', 'url' => '/', 'icon' => null, 'target' => '_self', 'order' => 1],
            ['label' => 'Tentang Prodi', 'url' => '/tentang', 'icon' => null, 'target' => '_self', 'order' => 2],
            ['label' => 'Pendidikan', 'url' => '/akademik', 'icon' => null, 'target' => '_self', 'order' => 3],
            ['label' => 'Kurikulum', 'url' => '/kurikulum', 'icon' => null, 'target' => '_self', 'order' => 4],
            ['label' => 'Kalender Akademik', 'url' => '/kalender-akademik', 'icon' => null, 'target' => '_self', 'order' => 5],
            ['label' => 'Penelitian', 'url' => '/penelitian', 'icon' => null, 'target' => '_self', 'order' => 6],
            ['label' => 'Pengabdian Masyarakat', 'url' => '/pengabdian', 'icon' => null, 'target' => '_self', 'order' => 7],
            ['label' => 'Galeri Foto', 'url' => '/galeri', 'icon' => null, 'target' => '_self', 'order' => 8],
            ['label' => 'Agenda', 'url' => '/agenda', 'icon' => null, 'target' => '_self', 'order' => 9],
            ['label' => 'Kontak', 'url' => '/kontak', 'icon' => null, 'target' => '_self', 'order' => 10],
        ];

        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $footerMenu->id, 'parent_id' => null]));
        }
    }
}
