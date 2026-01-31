<?php

namespace App\Livewire\Kepegawaian;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use App\Models\KinerjaPegawai;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\JadwalJaga;
use App\Models\Shift;
use Carbon\Carbon;

class DashboardPegawai extends Component
{
    public function render()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        $today = Carbon::today();

        // 1. Data Presensi Hari Ini
        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        // 2. Jadwal Hari Ini
        $jadwalHariIni = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawai->id ?? 0)
            ->whereDate('tanggal', $today)
            ->first();

        // 3. Statistik Ringkas
        $stats = [
            'sisa_cuti' => $pegawai->sisa_cuti ?? 0,
            'hadir_bulan_ini' => Presensi::where('user_id', $user->id)
                ->whereMonth('created_at', Carbon::now()->month)
                ->where('status_kehadiran', 'Hadir')
                ->count(),
            'lembur_bulan_ini' => \App\Models\Lembur::where('user_id', $user->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->where('status', 'Disetujui')
                ->get()
                ->sum(function($item) {
                    return \Carbon\Carbon::parse($item->jam_mulai)
                        ->diffInMinutes(\Carbon\Carbon::parse($item->jam_selesai)) / 60;
                }),
            'poin_kinerja' => KinerjaPegawai::where('pegawai_id', $pegawai->id ?? 0)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get()
                ->avg('nilai_rata_rata') ?? 0,
        ];

        // 4. Aktivitas Terakhir (Timeline)
        $activities = collect();
        
        // Add Presensi Logs
        $logPresensi = Presensi::where('user_id', $user->id)->latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'presensi',
                'title' => 'Presensi ' . ($item->jam_keluar ? 'Pulang' : 'Masuk'),
                'time' => $item->updated_at,
                'desc' => $item->jam_masuk . ($item->jam_keluar ? ' - ' . $item->jam_keluar : ''),
                'status' => $item->status_kehadiran
            ];
        });

        // Add Cuti Logs
        $logCuti = PengajuanCuti::where('user_id', $user->id)->latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'cuti',
                'title' => 'Pengajuan Cuti',
                'time' => $item->created_at,
                'desc' => $item->jenis_cuti . ' (' . $item->durasi_hari . ' hari)',
                'status' => $item->status
            ];
        });

        $timeline = $logPresensi->merge($logCuti)->sortByDesc('time')->take(5);

        // 5. Shift Berikutnya
        $nextShift = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawai->id ?? 0)
            ->whereDate('tanggal', '>', $today)
            ->orderBy('tanggal')
            ->first();

        return view('livewire.kepegawaian.dashboard-pegawai', compact(
            'user', 
            'pegawai', 
            'presensiHariIni', 
            'jadwalHariIni', 
            'stats', 
            'timeline',
            'nextShift'
        ))->layout('layouts.app', ['header' => 'Portal Pegawai']);
    }
}