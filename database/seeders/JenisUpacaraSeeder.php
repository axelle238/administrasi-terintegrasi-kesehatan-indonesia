<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisUpacara;

class JenisUpacaraSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_upacara' => 'Upacara Bendera Senin', 'kategori' => 'Rutin', 'poin_kredit' => 1],
            ['nama_upacara' => 'Apel Pagi (Harian)', 'kategori' => 'Rutin', 'poin_kredit' => 1],
            ['nama_upacara' => 'HUT Kemerdekaan RI (17 Agustus)', 'kategori' => 'Hari Besar', 'poin_kredit' => 5],
            ['nama_upacara' => 'Hari Pahlawan (10 November)', 'kategori' => 'Hari Besar', 'poin_kredit' => 3],
            ['nama_upacara' => 'Hari Kesehatan Nasional', 'kategori' => 'Hari Besar', 'poin_kredit' => 3],
            ['nama_upacara' => 'Upacara Korpri', 'kategori' => 'Rutin', 'poin_kredit' => 2],
        ];

        foreach ($data as $item) {
            JenisUpacara::create($item);
        }
    }
}