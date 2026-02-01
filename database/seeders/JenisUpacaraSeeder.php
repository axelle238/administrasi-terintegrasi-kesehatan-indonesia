<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisUpacara;

class JenisUpacaraSeeder extends Seeder
{
    public function run(): void
    {
        // Koordinat Dummy: Monas Jakarta
        $lat = '-6.1753924';
        $long = '106.8271528';

        $data = [
            ['nama_upacara' => 'Upacara Bendera Senin', 'kategori' => 'Rutin', 'poin_kredit' => 1, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 200],
            ['nama_upacara' => 'Apel Pagi (Harian)', 'kategori' => 'Rutin', 'poin_kredit' => 1, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 100],
            ['nama_upacara' => 'HUT Kemerdekaan RI (17 Agustus)', 'kategori' => 'Hari Besar', 'poin_kredit' => 5, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 500],
            ['nama_upacara' => 'Hari Pahlawan (10 November)', 'kategori' => 'Hari Besar', 'poin_kredit' => 3, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 300],
            ['nama_upacara' => 'Hari Kesehatan Nasional', 'kategori' => 'Hari Besar', 'poin_kredit' => 3, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 300],
            ['nama_upacara' => 'Upacara Korpri', 'kategori' => 'Rutin', 'poin_kredit' => 2, 'target_latitude' => $lat, 'target_longitude' => $long, 'radius_meter' => 200],
        ];

        foreach ($data as $item) {
            JenisUpacara::updateOrCreate(
                ['nama_upacara' => $item['nama_upacara']], // Key untuk cek duplikat
                $item
            );
        }
    }
}