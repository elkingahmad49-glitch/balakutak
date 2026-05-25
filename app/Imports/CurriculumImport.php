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
            'tipe' => 'required|string|in:wajib,pilihan',
        ];
    }

    /**
     * Sanitize and normalize input data before validation.
     */
    public function prepareForValidation(array $data, $index): array
    {
        if (isset($data['kode'])) {
            $data['kode'] = trim((string)$data['kode']);
        }

        if (isset($data['nama'])) {
            $data['nama'] = trim((string)$data['nama']);
        }

        if (isset($data['semester'])) {
            $semRaw = trim((string)$data['semester']);
            // Convert Roman numerals to integer values
            $romanVal = $this->romanToInteger($semRaw);
            if ($romanVal !== null) {
                $data['semester'] = $romanVal;
            } else {
                // Extract digits (e.g. "Semester 3" -> 3)
                preg_match('/\d+/', $semRaw, $matches);
                if (isset($matches[0])) {
                    $data['semester'] = (int)$matches[0];
                } else {
                    $data['semester'] = null; // Let validation catch it
                }
            }
        }

        if (isset($data['sks'])) {
            $sksRaw = trim((string)$data['sks']);
            preg_match('/\d+/', $sksRaw, $matches);
            if (isset($matches[0])) {
                $data['sks'] = (int)$matches[0];
            } else {
                $data['sks'] = null; // Let validation catch it
            }
        }

        if (isset($data['tipe'])) {
            $tipeRaw = strtolower(trim((string)$data['tipe']));
            if (str_contains($tipeRaw, 'pilihan') || str_contains($tipeRaw, 'pilih') || str_contains($tipeRaw, 'pili')) {
                $data['tipe'] = 'pilihan';
            } else {
                $data['tipe'] = 'wajib';
            }
        }

        return $data;
    }

    /**
     * Convert Roman numerals (I-X) to integer value.
     */
    private function romanToInteger(string $roman): ?int
    {
        $roman = strtoupper(trim($roman));
        $romans = [
            'I'    => 1,
            'II'   => 2,
            'III'  => 3,
            'IV'   => 4,
            'V'    => 5,
            'VI'   => 6,
            'VII'  => 7,
            'VIII' => 8,
            'IX'   => 9,
            'X'    => 10,
        ];
        return $romans[$roman] ?? null;
    }
}
