<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\Penggajian;
use App\Models\KomponenGaji;
use App\Models\Lembur;
use App\Models\Presensi;
use Carbon\Carbon;

class PayrollService
{
    public function generateSlip(Pegawai $pegawai, $bulan, $tahun)
    {
        // 1. Inisialisasi
        $gajiPokok = $pegawai->gaji_pokok;
        $totalTunjangan = 0;
        $totalPotongan = 0;
        
        // 2. Hitung Tunjangan Tetap (Dari Master Komponen)
        $tunjanganTetap = KomponenGaji::where('jenis', 'Penerimaan')->where('is_active', true)->get();
        foreach ($tunjanganTetap as $t) {
            $totalTunjangan += $t->nilai_default;
        }

        // 3. Hitung Lembur
        $lembur = Lembur::where('user_id', $pegawai->user_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'Disetujui')
            ->get();
            
        // Asumsi hitungan lembur sederhana: durasi * 20.000
        $totalJamLembur = 0;
        foreach ($lembur as $l) {
            $start = Carbon::parse($l->jam_mulai);
            $end = Carbon::parse($l->jam_selesai);
            $totalJamLembur += $end->diffInHours($start);
        }
        $uangLembur = $totalJamLembur * 20000;
        $totalTunjangan += $uangLembur;

        // 4. Hitung Potongan (Misal: Terlambat)
        $terlambat = Presensi::where('user_id', $pegawai->user_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status_masuk', 'Terlambat')
            ->count();
        
        $potonganTelat = $terlambat * 50000; // Denda 50k per telat
        $totalPotongan += $potonganTelat;

        // 5. Create Penggajian Header
        $penggajian = Penggajian::create([
            'user_id' => $pegawai->user_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gajiPokok,
            'total_tunjangan' => $totalTunjangan,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => ($gajiPokok + $totalTunjangan) - $totalPotongan,
            'status' => 'Draft'
        ]);

        // 6. Simpan Detail
        $this->saveDetail($penggajian, 'Gaji Pokok', 'Penerimaan', $gajiPokok);
        $this->saveDetail($penggajian, 'Uang Lembur', 'Penerimaan', $uangLembur);
        if ($potonganTelat > 0) {
            $this->saveDetail($penggajian, 'Denda Keterlambatan', 'Potongan', $potonganTelat);
        }
        // ... simpan detail lain dari loop tunjanganTetap ...

        return $penggajian;
    }

    private function saveDetail($penggajian, $nama, $jenis, $jumlah)
    {
        $penggajian->details()->create([
            'nama_komponen' => $nama,
            'jenis' => $jenis,
            'jumlah' => $jumlah
        ]);
    }
}