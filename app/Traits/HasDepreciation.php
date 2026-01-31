<?php

namespace App\Traits;

use App\Models\DepresiasiAset;
use Carbon\Carbon;

trait HasDepreciation
{
    /**
     * Hitung penyusutan tahunan (Metode Garis Lurus).
     */
    public function calculateDepreciation()
    {
        if (!$this->is_asset || $this->harga_perolehan <= 0 || $this->masa_manfaat <= 0) {
            return 0;
        }

        $depreciableAmount = $this->harga_perolehan - $this->nilai_residu;
        return $depreciableAmount / $this->masa_manfaat;
    }

    /**
     * Generate tabel penyusutan untuk aset ini.
     */
    public function generateDepreciationSchedule()
    {
        if (!$this->is_asset) return;

        $annualDepreciation = $this->calculateDepreciation();
        $currentValue = $this->harga_perolehan;
        $year = Carbon::parse($this->tanggal_pengadaan)->year;

        // Hapus history lama jika ada (Reset)
        $this->depresiasi()->delete();

        for ($i = 1; $i <= $this->masa_manfaat; $i++) {
            $year++;
            $penyusutanTahunIni = $annualDepreciation;
            
            // Adjust last year to match residual value exactly due to rounding
            if ($i == $this->masa_manfaat) {
                $penyusutanTahunIni = $currentValue - $this->nilai_residu;
            }

            $currentValue -= $penyusutanTahunIni;

            DepresiasiAset::create([
                'barang_id' => $this->id,
                'tahun_ke' => $i,
                'nilai_buku_awal' => $currentValue + $penyusutanTahunIni,
                'nilai_penyusutan' => $penyusutanTahunIni,
                'nilai_buku_akhir' => max($currentValue, 0), // Prevent negative
                'created_at' => now(), // Or specific date
            ]);
        }
        
        // Update nilai buku di tabel master
        $this->update(['nilai_buku' => max($currentValue, 0)]);
    }
}
