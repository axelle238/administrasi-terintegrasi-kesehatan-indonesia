<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\KinerjaPegawai;
use App\Models\JadwalJaga;
use App\Models\Penggajian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $activeTab = 'ikhtisar'; // ikhtisar, presensi, cuti, kinerja

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // === GLOBAL METRICS ===
        $totalPegawai = Pegawai::count();
        $totalUser = User::count();
        $pegawaiAktif = Pegawai::where('status_kepegawaian', '!=', 'Resign')->count();
        
        // Peringatan STR/SIP
        $batasPeringatan = Carbon::now()->addMonths(3);
        $dokumenExpired = Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)
            ->orWhere('masa_berlaku_sip', '<=', $batasPeringatan)
            ->count();

        $tabData = [];

        // === TAB 1: IKHTISAR ===
        if ($this->activeTab == 'ikhtisar') {
            $tabData['komposisiRole'] = User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get();
            
            $tabData['dokumenAlert'] = Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)
                ->orWhere('masa_berlaku_sip', '<=', $batasPeringatan)
                ->with('user')
                ->take(5)
                ->get();

            $tabData['gajiBulanIni'] = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))
                ->where('tahun', Carbon::now()->year)
                ->sum('total_gaji');
        }

        // === TAB 2: PRESENSI & JADWAL ===
        if ($this->activeTab == 'presensi') {
            $jadwalQuery = JadwalJaga::with('pegawai.user', 'shift')
                ->whereDate('tanggal', Carbon::today());
            
            $dijadwalkan = $jadwalQuery->count();
            // Simulasi kehadiran (karena belum ada data riil presensi di DB)
            $hadir = max(0, floor($dijadwalkan * 0.9)); 
            
            $tabData['statistikKehadiran'] = [
                'total' => $dijadwalkan,
                'hadir' => $hadir,
                'absen' => max(0, $dijadwalkan - $hadir)
            ];
            
            $tabData['jadwalHariIni'] = $jadwalQuery->get();
        }

        // === TAB 3: CUTI ===
        if ($this->activeTab == 'cuti') {
            $tabData['cutiPending'] = PengajuanCuti::with('user')->where('status', 'Menunggu')->get();
            $tabData['sedangCuti'] = PengajuanCuti::with('user')
                ->where('status', 'Disetujui')
                ->whereDate('tanggal_mulai', '<=', Carbon::today())
                ->whereDate('tanggal_selesai', '>=', Carbon::today())
                ->get();
            
            // Statistik Jenis Cuti (Tahunan, Sakit, Melahirkan, dll)
            $tabData['jenisCuti'] = PengajuanCuti::select('jenis_cuti', DB::raw('count(*) as total'))
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('jenis_cuti')
                ->get();
        }

        // === TAB 4: KINERJA ===
        if ($this->activeTab == 'kinerja') {
            $tabData['topPerformance'] = KinerjaPegawai::with('pegawai.user')
                ->whereMonth('created_at', Carbon::now()->month)
                ->select('*', DB::raw('(orientasi_pelayanan + integritas + komitmen + disiplin + kerjasama) / 5 as rata_rata'))
                ->orderByDesc('rata_rata')
                ->limit(5)
                ->get();
            
            $tabData['trenKinerja'] = $this->getTrenKinerja();
        }

        return view('livewire.hrd.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'dokumenExpired',
            'tabData'
        ))->layout('layouts.app', ['header' => 'Manajemen Sumber Daya Manusia']);
    }

    private function getTrenKinerja()
    {
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');
            
            $avg = KinerjaPegawai::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->select(DB::raw('AVG((orientasi_pelayanan + integritas + komitmen + disiplin + kerjasama) / 5) as avg_score'))
                ->value('avg_score');
                
            $data[] = round($avg ?? 0, 2); // Skor rata-rata 0-100 atau skala lain
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
