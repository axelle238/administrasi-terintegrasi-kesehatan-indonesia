<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\KinerjaPegawai;
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

        // 4. Kinerja Bulan Ini (Top 5)
        $topKinerja = KinerjaPegawai::with('pegawai.user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->select('*', DB::raw('(orientasi_pelayanan + integritas + komitmen + disiplin + kerjasama) as total_skor'))
            ->orderByDesc('total_skor')
            ->limit(5)
            ->get();

        // 5. Peringatan Dini (EWS) STR/SIP
        $batasPeringatan = Carbon::now()->addMonths(3);
        $strExpired = Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)->count();
        $sipExpired = Pegawai::where('masa_berlaku_sip', '<=', $batasPeringatan)->count();

        // 6. Tren Kinerja Rata-rata (6 Bulan Terakhir)
        $trenKinerja = $this->getTrenKinerja();

        // 7. Daftar Pegawai Cuti Hari Ini
        $listCutiHariIni = PengajuanCuti::with('user')
            ->where('status', 'Disetujui')
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_selesai', '>=', Carbon::today())
            ->get();

        return view('livewire.hrd.dashboard', compact(
            'totalPegawai',
            'pegawaiCutiHariIni',
            'komposisiRole',
            'jadwalHariIni',
            'topKinerja',
            'strExpired',
            'sipExpired',
            'trenKinerja',
            'listCutiHariIni'
        ))->layout('layouts.app', ['header' => 'Dashboard SDM & Kepegawaian']);
    }

    private function getTrenKinerja()
    {
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            // Hitung rata-rata skor total seluruh pegawai
            $avg = KinerjaPegawai::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->select(DB::raw('AVG(orientasi_pelayanan + integritas + komitmen + disiplin + kerjasama) as avg_score'))
                ->value('avg_score');
                
            $data[] = round($avg ?? 0, 1);
        }

        return ['labels' => $labels, 'data' => $data];
    }
}