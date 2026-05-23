<?php

namespace App\Imports;

use App\Models\Lecturer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class LecturersImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Sanitize URLs
        $urlFields = [
            'google_scholar_url', 'sinta_url', 'garuda_url', 'linkedin_url', 'website_url'
        ];

        foreach ($urlFields as $field) {
            if (!empty($row[$field])) {
                $value = trim($row[$field]);
                if (!preg_match('~^(?:f|ht)tps?://~i', $value)) {
                    $row[$field] = 'https://' . $value;
                }
            }
        }

        // Find existing lecturer by NIP or NIDN to avoid unique violations and support updates
        $existing = null;
        if (!empty($row['nip'])) {
            $existing = Lecturer::where('nip', $row['nip'])->first();
        }
        if (!$existing && !empty($row['nidn'])) {
            $existing = Lecturer::where('nidn', $row['nidn'])->first();
        }

        if ($existing) {
            $existing->update([
                'name' => $row['nama_lengkap'] ?? $existing->name,
                'type' => strtolower($row['tipe_dosentendik'] ?? '') === 'tendik' ? 'tendik' : 'dosen',
                'academic_title' => $row['jabatan_akademik'] ?? $existing->academic_title,
                'functional_position' => $row['jabatan_struktural'] ?? $existing->functional_position,
                'position' => $row['jabatan_umum'] ?? $existing->position,
                'expertise' => $row['keahlian'] ?? $existing->expertise,
                'education' => $row['pendidikan'] ?? $existing->education,
                'email' => $row['email'] ?? $existing->email,
                'phone' => $row['phone'] ?? $existing->phone,
                'google_scholar_url' => $row['google_scholar_url'] ?? $existing->google_scholar_url,
                'sinta_url' => $row['sinta_url'] ?? $existing->sinta_url,
                'garuda_url' => $row['garuda_url'] ?? $existing->garuda_url,
                'linkedin_url' => $row['linkedin_url'] ?? $existing->linkedin_url,
                'website_url' => $row['website_url'] ?? $existing->website_url,
                'biography' => $row['biografi'] ?? $existing->biography,
            ]);
            return null; // Skip insert, update has been handled
        }

        return new Lecturer([
            'name' => $row['nama_lengkap'] ?? null,
            'nip' => $row['nip'] ?? null,
            'nidn' => $row['nidn'] ?? null,
            'type' => strtolower($row['tipe_dosentendik'] ?? '') === 'tendik' ? 'tendik' : 'dosen',
            'academic_title' => $row['jabatan_akademik'] ?? null,
            'functional_position' => $row['jabatan_struktural'] ?? null,
            'position' => $row['jabatan_umum'] ?? null,
            'expertise' => $row['keahlian'] ?? null,
            'education' => $row['pendidikan'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'google_scholar_url' => $row['google_scholar_url'] ?? null,
            'sinta_url' => $row['sinta_url'] ?? null,
            'garuda_url' => $row['garuda_url'] ?? null,
            'linkedin_url' => $row['linkedin_url'] ?? null,
            'website_url' => $row['website_url'] ?? null,
            'biography' => $row['biografi'] ?? null,
            'is_active' => true,
            'order' => Lecturer::max('order') + 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'tipe_dosentendik' => 'required|string',
            'google_scholar_url' => 'nullable|string|max:255',
            'sinta_url' => 'nullable|string|max:255',
            'garuda_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'website_url' => 'nullable|string|max:255',
        ];
    }
}
