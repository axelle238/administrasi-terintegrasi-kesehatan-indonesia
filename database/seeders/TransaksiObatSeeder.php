<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\TransaksiObat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransaksiObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = Obat::all();

        foreach ($obats as $obat) {
            // Initial Stock (Masuk) - 1 Month Ago
            TransaksiObat::create([
                'obat_id' => $obat->id,
                'jenis_transaksi' => 'Masuk',
                'jumlah' => $obat->stok + 50, // Assume initial was higher
                'tanggal_transaksi' => Carbon::now()->subMonth()->startOfMonth(),
                'keterangan' => 'Stok Awal Bulan Lalu',
                'pencatat' => 'System'
            ]);

            // Usage (Keluar) - Various days
            for ($i = 0; $i < 5; $i++) {
                TransaksiObat::create([
                    'obat_id' => $obat->id,
                    'jenis_transaksi' => 'Keluar',
                    'jumlah' => rand(1, 5),
                    'tanggal_transaksi' => Carbon::now()->subDays(rand(1, 20)),
                    'keterangan' => 'Resep Pasien Umum',
                    'pencatat' => 'Apoteker'
                ]);
            }
        }
    }
}