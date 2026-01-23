<?php

namespace App\Console\Commands;

use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RecalculateDepreciation extends Command
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
    protected $description = 'Recalculate book value of assets based on Straight Line depreciation method';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting depreciation calculation...');

        $assets = Barang::where('is_asset', true)
            ->whereNotNull('tanggal_pengadaan')
            ->where('harga_perolehan', '>', 0)
            ->where('masa_manfaat', '>', 0)
            ->get();

        $count = 0;

        foreach ($assets as $asset) {
            $acquisitionDate = Carbon::parse($asset->tanggal_pengadaan);
            $now = now();
            
            // Calculate age in months
            $ageInMonths = $acquisitionDate->diffInMonths($now);
            $usefulLifeMonths = $asset->masa_manfaat * 12;

            if ($ageInMonths >= $usefulLifeMonths) {
                // Fully depreciated
                $currentValue = $asset->nilai_residu;
            } else {
                // Calculate monthly depreciation
                $depreciableAmount = $asset->harga_perolehan - $asset->nilai_residu;
                $monthlyDepreciation = $depreciableAmount / $usefulLifeMonths;
                $accumulatedDepreciation = $monthlyDepreciation * $ageInMonths;
                $currentValue = $asset->harga_perolehan - $accumulatedDepreciation;
            }

            // Ensure not below residual value (or 0 if no residual)
            $currentValue = max($currentValue, $asset->nilai_residu);

            $asset->update(['nilai_buku' => $currentValue]);
            $count++;
        }

        $this->info("Successfully updated {$count} assets.");
    }
}