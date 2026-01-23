<?php

namespace Database\Seeders;

use App\Models\Icd10;
use Illuminate\Database\Seeder;

class Icd10Seeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['code' => 'A00', 'name_en' => 'Cholera', 'name_id' => 'Kolera'],
            ['code' => 'A01', 'name_en' => 'Typhoid and paratyphoid fevers', 'name_id' => 'Demam tifoid dan paratifoid'],
            ['code' => 'A09', 'name_en' => 'Infectious gastroenteritis and colitis, unspecified', 'name_id' => 'Diare dan gastroenteritis infeksi'],
            ['code' => 'J00', 'name_en' => 'Acute nasopharyngitis [common cold]', 'name_id' => 'Nasofaringitis akut (common cold)'],
            ['code' => 'J06.9', 'name_en' => 'Acute upper respiratory infection, unspecified', 'name_id' => 'ISPA (Infeksi Saluran Pernapasan Akut)'],
            ['code' => 'I10', 'name_en' => 'Essential (primary) hypertension', 'name_id' => 'Hipertensi esensial (primer)'],
            ['code' => 'E11', 'name_en' => 'Type 2 diabetes mellitus', 'name_id' => 'Diabetes melitus tipe 2'],
            ['code' => 'R51', 'name_en' => 'Headache', 'name_id' => 'Sakit kepala'],
            ['code' => 'R50.9', 'name_en' => 'Fever, unspecified', 'name_id' => 'Demam tidak spesifik'],
            ['code' => 'K29.7', 'name_en' => 'Gastritis, unspecified', 'name_id' => 'Gastritis (Maag)'],
        ];

        foreach ($data as $item) {
            Icd10::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}