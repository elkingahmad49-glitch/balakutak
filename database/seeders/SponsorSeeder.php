<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Copy seed images to public storage
        $this->ensureSeedAssets();

        $sponsors = [
            [
                'name' => 'Vertex Solutions',
                'logo' => 'sponsors/sponsor_1.png',
                'url' => 'https://vertexsolutions.example.com',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Nova Energy',
                'logo' => 'sponsors/sponsor_2.png',
                'url' => 'https://novaenergy.example.com',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($sponsors as $data) {
            Sponsor::create($data);
        }
    }

    /**
     * Ensure the seed assets are copied to public storage.
     */
    private function ensureSeedAssets(): void
    {
        $assetPath = database_path('seeders/assets/sponsors');
        if (File::exists($assetPath)) {
            if (!Storage::disk('public')->exists('sponsors')) {
                Storage::disk('public')->makeDirectory('sponsors');
            }
            $files = File::files($assetPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                Storage::disk('public')->put("sponsors/$filename", File::get($file->getRealPath()));
            }
        }
    }
}
