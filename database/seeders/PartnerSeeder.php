<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Copy seed images to public storage
        $this->ensureSeedAssets();

        $partners = [
            [
                'name' => 'Aetheric Labs',
                'logo' => 'partners/partner_1.png',
                'website_url' => 'https://aethericlabs.example.com',
                'description' => 'Fictional partner Aetheric Labs focusing on hardware and biotechnology.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Nexus Dynamics',
                'logo' => 'partners/partner_2.png',
                'website_url' => 'https://nexusdynamics.example.com',
                'description' => 'Fictional partner Nexus Dynamics focusing on cloud infrastructure and security.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Vortex Systems',
                'logo' => 'partners/partner_3.png',
                'website_url' => 'https://vortexsystems.example.com',
                'description' => 'Fictional partner Vortex Systems focusing on machine learning and database systems.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Apex Horizon',
                'logo' => 'partners/partner_4.png',
                'website_url' => 'https://apexhorizon.example.com',
                'description' => 'Fictional partner Apex Horizon focusing on education and satellite imagery.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $data) {
            Partner::create($data);
        }
    }

    private function ensureSeedAssets()
    {
        $assetPath = database_path('seeders/assets/partners');
        if (File::exists($assetPath)) {
            if (!Storage::disk('public')->exists('partners')) {
                Storage::disk('public')->makeDirectory('partners');
            }
            $files = File::files($assetPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                Storage::disk('public')->put("partners/$filename", File::get($file->getRealPath()));
            }
        }
    }
}
