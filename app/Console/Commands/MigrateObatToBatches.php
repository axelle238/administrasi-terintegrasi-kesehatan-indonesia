<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Obat;
use App\Models\ObatBatch;

class MigrateObatToBatches extends Command
{
    protected $signature = 'obat:migrate-batches';
    protected $description = 'Move existing obat stock to a default batch';

    public function handle()
    {
        $obats = Obat::whereDoesntHave('batches')->get();
        foreach ($obats as $obat) {
            if ($obat->stok > 0) {
                ObatBatch::create([
                    'obat_id' => $obat->id,
                    'batch_number' => 'INITIAL-' . date('Ymd'),
                    'tanggal_kedaluwarsa' => $obat->tanggal_kedaluwarsa ?? now()->addYear(),
                    'stok' => $obat->stok,
                    'harga_beli' => $obat->harga_satuan * 0.8 // Estimate
                ]);
                $this->info("Migrated {$obat->nama_obat}: {$obat->stok}");
            }
        }
    }
}