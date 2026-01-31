<?php

namespace App\Traits;

use App\Models\DepresiasiAset; // Pastikan model ini mengarah ke tabel 'depresiasi_logs'
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasDepreciation
{
    /**
     * Hitung penyusutan bulanan (Metode Garis Lurus).
     */
    public function calculateMonthlyDepreciation()
    {
        // Validasi data dasar
        if (!$this->is_asset || $this->harga_perolehan <= 0 || $this->masa_manfaat <= 0) {
            return 0;
        }

        // Rumus: (Harga Perolehan - Nilai Residu) / (Tahun * 12 Bulan)
        $depreciableAmount = $this->harga_perolehan - $this->nilai_residu;
        $totalMonths = $this->masa_manfaat * 12;
        
        return $depreciableAmount / $totalMonths;
    }

    /**
     * Generate tabel simulasi penyusutan BULANAN untuk aset ini.
     * Ini akan mengisi tabel 'depresiasi_logs' dengan data forecast.
     */
    public function generateDepreciationSchedule()
    {
        if (!$this->is_asset) return;

        $monthlyDepreciation = $this->calculateMonthlyDepreciation();
        $currentValue = $this->harga_perolehan;
        
        // Start date = tanggal pengadaan (dianggap awal bulan berikutnya jika beli di tengah bulan, 
        // atau bulan yang sama. Standard akuntansi: penyusutan dimulai bulan penggunaan).
        // Kita gunakan start of month dari tanggal pengadaan.
        $startDate = Carbon::parse($this->tanggal_pengadaan)->startOfMonth();
        $totalMonths = $this->masa_manfaat * 12;

        // Bersihkan log lama untuk regenerasi bersih
        // Asumsi relasi 'depresiasi' ada di model Barang
        $this->depresiasi()->delete();

        $logs = [];
        $now = now();

        for ($i = 1; $i <= $totalMonths; $i++) {
            $currentMonth = $startDate->copy()->addMonths($i - 1);
            $penyusutanBulanIni = $monthlyDepreciation;
            
            // Penyesuaian di bulan terakhir untuk pembulatan
            if ($i == $totalMonths) {
                $penyusutanBulanIni = $currentValue - $this->nilai_residu;
            }

            // Safety check: jangan sampai nilai buku < nilai residu
            if ($currentValue < $this->nilai_residu) {
                $penyusutanBulanIni = 0;
            }

            $nilaiAwal = $currentValue;
            $currentValue -= $penyusutanBulanIni;

            $logs[] = [
                'barang_id' => $this->id,
                'periode_bulan' => $currentMonth->format('Y-m-d'),
                'nilai_buku_awal' => $nilaiAwal,
                'nilai_penyusutan' => $penyusutanBulanIni,
                'nilai_buku_akhir' => max($currentValue, 0),
                'metode' => 'Garis Lurus',
                'created_by' => Auth::id() ?? 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Bulk Insert untuk performa
        if (!empty($logs)) {
            DepresiasiAset::insert($logs);
        }
        
        // Update nilai buku MASTER ke posisi real-time (Hari Ini)
        $currentLog = DepresiasiAset::where('barang_id', $this->id)
            ->where('periode_bulan', '<=', now()->endOfMonth())
            ->orderByDesc('periode_bulan')
            ->first();

        if ($currentLog) {
            $this->update(['nilai_buku' => $currentLog->nilai_buku_akhir]);
        }
    }
}
