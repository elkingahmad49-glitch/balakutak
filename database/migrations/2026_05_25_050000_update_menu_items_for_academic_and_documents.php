<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update URL from /layanan-akademik to /academic-services
        // And update label if it was "Layanan Akademik" to "Sistem & Layanan"
        DB::table('menu_items')
            ->where('url', '/layanan-akademik')
            ->update([
                'url' => '/academic-services',
                'label' => DB::raw("CASE WHEN label = 'Layanan Akademik' THEN 'Sistem & Layanan' ELSE label END")
            ]);

        // Also update any menu item pointing to /dokumen with label "Arsip Dokumen" or "Dokumen" to "Prosedur & Form"
        DB::table('menu_items')
            ->where('url', '/dokumen')
            ->whereIn('label', ['Arsip Dokumen', 'Dokumen'])
            ->update([
                'label' => 'Prosedur & Form'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert URL and labels
        DB::table('menu_items')
            ->where('url', '/academic-services')
            ->update([
                'url' => '/layanan-akademik',
                'label' => DB::raw("CASE WHEN label = 'Sistem & Layanan' THEN 'Layanan Akademik' ELSE label END")
            ]);

        DB::table('menu_items')
            ->where('url', '/dokumen')
            ->where('label', 'Prosedur & Form')
            ->update([
                'label' => 'Arsip Dokumen'
            ]);
    }
};
