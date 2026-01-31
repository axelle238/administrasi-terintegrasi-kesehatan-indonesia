<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Barang;

class CalculateAssetDepreciation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:calculate-depreciation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hitung ulang penyusutan aset tetap (Depresiasi) dan update nilai buku';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perhitungan depresiasi aset...');

        $assets = Barang::where('is_asset', true)
            ->whereNotNull('harga_perolehan')
            ->where('harga_perolehan', '>', 0)
            ->get();

        $bar = $this->output->createProgressBar(count($assets));
        $bar->start();

        foreach ($assets as $asset) {
            $asset->generateDepreciationSchedule();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Perhitungan selesai. Nilai buku aset telah diperbarui.');
    }
}