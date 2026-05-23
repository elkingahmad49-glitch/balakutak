<?php

namespace App\Imports;

use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class CurriculumImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new Curriculum([
            'code' => $row['kode'] ?? null,
            'name' => $row['nama'] ?? null,
            'semester' => $row['semester'] ?? null,
            'credits' => $row['sks'] ?? null,
            'description' => $row['deskripsi'] ?? null,
            'type' => strtolower($row['tipe'] ?? '') === 'pilihan' ? 'pilihan' : 'wajib',
            'concentration' => $row['konsentrasi'] ?? null,
            'is_active' => isset($row['aktif']) ? (bool)$row['aktif'] : true,
            'order' => Curriculum::max('order') + 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'sks' => 'required|integer|min:0|max:10',
            'tipe' => 'required|string|in:wajib,pilihan,Wajib,Pilihan',
        ];
    }
}
