<?php

namespace App\Imports;

use App\Models\ResearchService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class ResearchServicesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Sanitize External Link
        if (!empty($row['link_eksternal'])) {
            $value = trim($row['link_eksternal']);
            if (!preg_match('~^(?:f|ht)tps?://~i', $value)) {
                $row['link_eksternal'] = 'https://' . $value;
            }
        }

        // Determine Type
        $typeInput = strtolower(trim($row['tipe_penelitianpengabdian'] ?? ''));
        $type = 'research';
        if (in_array($typeInput, ['pengabdian', 'pengabdian masyarakat', 'community_service', 'community service'])) {
            $type = 'community_service';
        }

        // Find existing record by title and type to update or insert
        $existing = ResearchService::where('title', trim($row['judul']))
            ->where('type', $type)
            ->first();

        if ($existing) {
            $existing->update([
                'author' => $row['peneliti_pelaksana'] ?? $existing->author,
                'year' => $row['tahun'] ?? $existing->year,
                'abstract' => $row['abstrak'] ?? $existing->abstract,
                'content' => $row['deskripsi'] ?? $existing->content,
                'external_link' => $row['link_eksternal'] ?? $existing->external_link,
                'order' => isset($row['urutan']) ? intval($row['urutan']) : $existing->order,
            ]);
            return null; // Skip insert
        }

        return new ResearchService([
            'title' => trim($row['judul']),
            'author' => $row['peneliti_pelaksana'] ?? null,
            'year' => $row['tahun'] ?? null,
            'type' => $type,
            'abstract' => $row['abstrak'] ?? null,
            'content' => $row['deskripsi'] ?? null,
            'external_link' => $row['link_eksternal'] ?? null,
            'is_active' => true,
            'order' => isset($row['urutan']) ? intval($row['urutan']) : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'peneliti_pelaksana' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|digits:4',
            'tipe_penelitianpengabdian' => 'required|string',
            'link_eksternal' => 'nullable|string|max:255',
        ];
    }
}
