<?php

namespace Database\Seeders;

use App\Models\Tindakan;
use App\Models\Poli;
use Illuminate\Database\Seeder;

class TindakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID Poli
        $poliUmum = Poli::where('nama_poli', 'Poli Umum')->first()->id ?? 1;
        $poliGigi = Poli::where('nama_poli', 'Poli Gigi')->first()->id ?? 2;
        $poliKia = Poli::where('nama_poli', 'Poli KIA')->first()->id ?? 3;

        $data = [
            ['nama_tindakan' => 'Pemeriksaan Umum', 'poli_id' => $poliUmum, 'harga' => 15000],
            ['nama_tindakan' => 'Suntik Vitamin', 'poli_id' => $poliUmum, 'harga' => 25000],
            ['nama_tindakan' => 'Jahit Luka Ringan (1-3 Jahitan)', 'poli_id' => $poliUmum, 'harga' => 50000],
            ['nama_tindakan' => 'Rawat Luka (Ganti Perban)', 'poli_id' => $poliUmum, 'harga' => 30000],
            ['nama_tindakan' => 'Nebulizer (Uap)', 'poli_id' => $poliUmum, 'harga' => 40000],
            
            ['nama_tindakan' => 'Cabut Gigi Susu', 'poli_id' => $poliGigi, 'harga' => 35000],
            ['nama_tindakan' => 'Cabut Gigi Dewasa', 'poli_id' => $poliGigi, 'harga' => 75000],
            ['nama_tindakan' => 'Tambal Gigi Sementara', 'poli_id' => $poliGigi, 'harga' => 45000],
            ['nama_tindakan' => 'Tambal Gigi Permanen', 'poli_id' => $poliGigi, 'harga' => 85000],
            ['nama_tindakan' => 'Scaling (Pembersihan Karang)', 'poli_id' => $poliGigi, 'harga' => 100000],

            ['nama_tindakan' => 'Pemeriksaan Kehamilan (ANC)', 'poli_id' => $poliKia, 'harga' => 20000],
            ['nama_tindakan' => 'Imunisasi Dasar', 'poli_id' => $poliKia, 'harga' => 0],
            ['nama_tindakan' => 'KB Suntik 1 Bulan', 'poli_id' => $poliKia, 'harga' => 20000],
        ];

        foreach ($data as $item) {
            Tindakan::create($item);
        }
    }
}
