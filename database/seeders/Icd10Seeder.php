<?php

namespace Database\Seeders;

use App\Models\Icd10;
use Illuminate\Database\Seeder;

class Icd10Seeder extends Seeder
{
    public function run(): void
    {
        // Sample Common ICD-10 Data for Puskesmas
        $data = [
            ['code' => 'A00', 'name_en' => 'Cholera', 'name_id' => 'Kolera'],
            ['code' => 'A01', 'name_en' => 'Typhoid and paratyphoid fevers', 'name_id' => 'Demam tifoid dan paratifoid'],
            ['code' => 'A09', 'name_en' => 'Infectious gastroenteritis and colitis, unspecified', 'name_id' => 'Diare dan gastroenteritis oleh penyebab infeksi tertentu'],
            ['code' => 'A15', 'name_en' => 'Respiratory tuberculosis, bacteriologically and histologically confirmed', 'name_id' => 'Tuberkulosis paru terkonfirmasi bakteriologis dan histologis'],
            ['code' => 'B01', 'name_en' => 'Varicella [chickenpox]', 'name_id' => 'Cacar air (Varicella)'],
            ['code' => 'B05', 'name_en' => 'Measles', 'name_id' => 'Campak'],
            ['code' => 'B26', 'name_en' => 'Mumps', 'name_id' => 'Gondongan'],
            ['code' => 'D50', 'name_en' => 'Iron deficiency anemia', 'name_id' => 'Anemia defisiensi besi'],
            ['code' => 'E10', 'name_en' => 'Type 1 diabetes mellitus', 'name_id' => 'Diabetes melitus tipe 1'],
            ['code' => 'E11', 'name_en' => 'Type 2 diabetes mellitus', 'name_id' => 'Diabetes melitus tipe 2'],
            ['code' => 'I10', 'name_en' => 'Essential (primary) hypertension', 'name_id' => 'Hipertensi esensial (primer)'],
            ['code' => 'J00', 'name_en' => 'Acute nasopharyngitis [common cold]', 'name_id' => 'Nasofaringitis akut (common cold)'],
            ['code' => 'J06', 'name_en' => 'Acute upper respiratory infections of multiple and unspecified sites', 'name_id' => 'Infeksi saluran pernapasan atas akut (ISPA)'],
            ['code' => 'J11', 'name_en' => 'Influenza due to unidentified influenza virus', 'name_id' => 'Influenza, virus tidak teridentifikasi'],
            ['code' => 'J20', 'name_en' => 'Acute bronchitis', 'name_id' => 'Bronkitis akut'],
            ['code' => 'J45', 'name_en' => 'Asthma', 'name_id' => 'Asma'],
            ['code' => 'K29', 'name_en' => 'Gastritis and duodenitis', 'name_id' => 'Gastritis dan duodenitis (Maag)'],
            ['code' => 'K30', 'name_en' => 'Dyspepsia', 'name_id' => 'Dispepsia'],
            ['code' => 'L20', 'name_en' => 'Atopic dermatitis', 'name_id' => 'Dermatitis atopik'],
            ['code' => 'M79', 'name_en' => 'Other soft tissue disorders, not elsewhere classified', 'name_id' => 'Nyeri otot (Myalgia)'],
            ['code' => 'R50', 'name_en' => 'Fever of other and unknown origin', 'name_id' => 'Demam yang tidak diketahui penyebabnya'],
            ['code' => 'R51', 'name_en' => 'Headache', 'name_id' => 'Sakit kepala'],
            ['code' => 'Z00', 'name_en' => 'General examination and investigation of persons without complaint and reported diagnosis', 'name_id' => 'Pemeriksaan kesehatan umum (MCU)'],
        ];

        foreach ($data as $item) {
            Icd10::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
