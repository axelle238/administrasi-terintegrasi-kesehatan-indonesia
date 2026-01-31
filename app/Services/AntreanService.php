<?php

namespace App\Services;

use App\Models\Antrean;
use App\Models\Poli;
use App\Models\JadwalJaga;
use Carbon\Carbon;

class AntreanService
{
    /**
     * Membuat tiket antrean baru.
     * 
     * @param int $pasienId ID Pasien
     * @param int $poliId ID Poliklinik Tujuan
     * @param string $sumber 'kiosk', 'mobile', 'admisi'
     * @return Antrean
     */
    public function buatAntrean($pasienId, $poliId, $sumber = 'kiosk')
    {
        $poli = Poli::find($poliId);
        
        // 1. Tentukan Kode Poli (A, B, C...)
        // Logika: Ambil huruf depan nama poli atau kode khusus dari DB jika ada
        $kodePoli = $poli->kode_antrean ?? strtoupper(substr($poli->nama_poli, 0, 1));
        
        // 2. Hitung Nomor Urut Hari Ini
        $tanggalHariIni = Carbon::today();
        
        $jumlahAntrean = Antrean::where('poli_id', $poliId)
            ->whereDate('tanggal_antrean', $tanggalHariIni)
            ->lockForUpdate() // Cegah race condition
            ->count();
            
        $nomorUrut = $jumlahAntrean + 1;
        $nomorAntreanFull = $kodePoli . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        // 3. Estimasi Waktu (Opsional: 15 menit per pasien)
        // $estimasiWaktu = $tanggalHariIni->copy()->addMinutes(8 * 60 + ($nomorUrut * 15)); 

        // 4. Simpan ke Database
        $antrean = Antrean::create([
            'pasien_id' => $pasienId,
            'poli_id' => $poliId,
            'nomor_antrean' => $nomorAntreanFull,
            'tanggal_antrean' => $tanggalHariIni,
            'status' => 'Menunggu',
            'sumber_pendaftaran' => $sumber,
            'waktu_checkin' => now(),
            // 'estimasi_dilayani' => $estimasiWaktu
        ]);

        return $antrean;
    }

    /**
     * Mendapatkan antrean berikutnya yang harus dipanggil.
     */
    public function getAntreanBerikutnya($poliId)
    {
        return Antrean::where('poli_id', $poliId)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Menunggu')
            ->orderBy('id', 'asc')
            ->first();
    }
}
