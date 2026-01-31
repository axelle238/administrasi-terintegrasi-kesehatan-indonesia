<?php

namespace App\Traits;

use App\Models\DepresiasiAset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasDepreciation
{
    /**
     * Hitung penyusutan bulanan (Metode Garis Lurus).
     */
    public function calculateMonthlyDepreciation()
    {
        if (!$this->is_asset || $this->harga_perolehan <= 0 || $this->masa_manfaat <= 0) {
            return 0;
        }

        $depreciableAmount = $this->harga_perolehan - $this->nilai_residu;
        return $depreciableAmount / ($this->masa_manfaat * 12); // Masa manfaat dalam tahun * 12 bulan
    }

    /**
     * Generate tabel penyusutan BULANAN untuk aset ini.
     */
    public function generateDepreciationSchedule()
    {
        if (!$this->is_asset) return;

        $monthlyDepreciation = $this->calculateMonthlyDepreciation();
        $currentValue = $this->harga_perolehan;
        
        // Start date = tanggal pengadaan
        $startDate = Carbon::parse($this->tanggal_pengadaan)->startOfMonth();
        $totalMonths = $this->masa_manfaat * 12;

        // Hapus log lama untuk regenerasi
        $this->depresiasi()->delete();

        for ($i = 1; $i <= $totalMonths; $i++) {
            // Pindah ke bulan berikutnya
            $currentMonth = $startDate->copy()->addMonths($i - 1);
            
            // Skip jika belum sampai bulan ini (untuk log future) 
            // Atau generate semua (Forecast)? "Very Complete" biasanya forecast.
            // Kita generate semua untuk forecast.

            $penyusutanBulanIni = $monthlyDepreciation;
            
            // Adjust bulan terakhir
            if ($i == $totalMonths) {
                $penyusutanBulanIni = $currentValue - $this->nilai_residu;
            }

            // Cegah nilai buku negatif
            if ($currentValue < $this->nilai_residu) {
                $penyusutanBulanIni = 0;
            }

            $nilaiAwal = $currentValue;
            $currentValue -= $penyusutanBulanIni;

            DepresiasiAset::create([
                'barang_id' => $this->id,
                'periode_bulan' => $currentMonth->format('Y-m-d'),
                'nilai_buku_awal' => $nilaiAwal,
                'nilai_penyusutan' => $penyusutanBulanIni,
                'nilai_buku_akhir' => max($currentValue, 0),
                'metode' => 'Garis Lurus',
                'created_by' => Auth::id() ?? 1 // Fallback system admin
            ]);
        }
        
        // Update nilai buku MASTER ke posisi saat ini (Hari Ini)
        // Cari log bulan ini atau bulan terakhir yang lewat
        $currentLog = $this->depresiasi()
            ->where('periode_bulan', '<=', now()->endOfMonth())
            ->orderByDesc('periode_bulan')
            ->first();

        if ($currentLog) {
            $this->update(['nilai_buku' => $currentLog->nilai_buku_akhir]);
        }
    }
}