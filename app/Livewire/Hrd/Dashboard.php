<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\PengajuanCuti; // Asumsi model Cuti ada
use App\Models\KinerjaPegawai; // Asumsi model Kinerja ada
use App\Models\JadwalJaga;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Statistik Pegawai
        $totalPegawai = Pegawai::count();
        $pegawaiHadirHariIni = 0; // Perlu integrasi absensi, sementara 0 atau dummy
        $pegawaiCutiHariIni = PengajuanCuti::where('status', 'Disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->count();

        // 2. Komposisi SDM
        $komposisiRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        // 3. Jadwal Jaga Hari Ini
        $jadwalHariIni = JadwalJaga::with('pegawai.user', 'shift')
            ->whereDate('tanggal', Carbon::today())
            ->get();

        // 4. Kinerja Bulan Ini (Top 5) - Mock logic jika belum ada data real
        $topKinerja = KinerjaPegawai::with('pegawai.user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->orderByDesc('skor_total')
            ->limit(5)
            ->get();

        // 5. Peringatan Dini (EWS) STR/SIP
        $batasPeringatan = Carbon::now()->addMonths(3);
        $strExpired = Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)->count();
        $sipExpired = Pegawai::where('masa_berlaku_sip', '<=', $batasPeringatan)->count();

        return view('livewire.hrd.dashboard', compact(
            'totalPegawai',
            'pegawaiCutiHariIni',
            'komposisiRole',
            'jadwalHariIni',
            'topKinerja',
            'strExpired',
            'sipExpired'
        ))->layout('layouts.app', ['header' => 'Dashboard SDM & Kepegawaian']);
    }
}
