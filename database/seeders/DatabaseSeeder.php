<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            SettingsSeeder::class,
            DocumentCategorySeeder::class,
            SampleDataSeeder::class,
            FaqSeeder::class,
            AnnouncementSeeder::class,
            EventSeeder::class,
            PostSeeder::class,
            TestimonialSeeder::class,
            PartnerSeeder::class,
            SponsorSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
