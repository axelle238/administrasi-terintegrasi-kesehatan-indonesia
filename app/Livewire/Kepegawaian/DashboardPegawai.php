<?php

namespace App\Livewire\Kepegawaian;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\JadwalJaga;
use App\Models\Penggajian;
use App\Models\KinerjaPegawai;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardPegawai extends Component
{
    public function render()
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('user_id', $user->id)->first();

        if (!$pegawai) {
            return view('livewire.kepegawaian.dashboard-pegawai-not-found')
                ->layout('layouts.app', ['header' => 'Dashboard Pegawai']);
        }

        // 1. Statistik Personal
        $cutiDiambil = PengajuanCuti::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('tanggal_mulai', date('Y'))
            ->get()
            ->sum(function ($cuti) {
                return Carbon::parse($cuti->tanggal_mulai)
                    ->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;
            });

        $sisaCuti = 12 - $cutiDiambil;

        $jadwalHariIni = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $gajiTerakhir = Penggajian::where('pegawai_id', $pegawai->id)
            ->latest()
            ->first();

        // 2. Kinerja Terakhir
        $kinerja = KinerjaPegawai::where('pegawai_id', $pegawai->id)
            ->latest()
            ->first();

        // 3. Riwayat Cuti Terbaru
        $riwayatCuti = PengajuanCuti::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.kepegawaian.dashboard-pegawai', [
            'pegawai' => $pegawai,
            'sisaCuti' => max(0, $sisaCuti),
            'jadwalHariIni' => $jadwalHariIni,
            'gajiTerakhir' => $gajiTerakhir,
            'kinerja' => $kinerja,
            'riwayatCuti' => $riwayatCuti,
            'dataPresensi' => $this->getPresensiStats($pegawai->id)
        ])->layout('layouts.app', ['header' => 'Portal Mandiri Pegawai']);
    }

    private function getPresensiStats($pegawaiId)
    {
        // Simulasi data presensi bulanan (Hadir, Izin, Alpa)
        // Karena sistem belum memiliki modul presensi rincian per jam, kita hitung dari jadwal
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        return [
            'hadir' => 20, // Mock data untuk visualisasi
            'izin' => 2,
            'alpa' => 0
        ];
    }
}
