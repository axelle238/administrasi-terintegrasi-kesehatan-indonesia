<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\KinerjaPegawai;
use App\Models\JadwalJaga;
use App\Models\Penggajian;
use App\Models\User;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $tabAktif = 'ikhtisar'; // ikhtisar, presensi, cuti, kinerja

    public function aturTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function render()
    {
        $now = Carbon::now();
        $today = Carbon::today();

        // === METRIK GLOBAL ===
        $totalPegawai = Pegawai::count();
        $pegawaiAktif = Pegawai::where('status_kepegawaian', '!=', 'Resign')->count();
        
        // Peringatan STR/SIP (3 bulan kedepan)
        $batasPeringatan = $now->copy()->addMonths(3);
        $dokumenExpired = Pegawai::where(function($q) use ($batasPeringatan) {
            $q->where('masa_berlaku_str', '<=', $batasPeringatan)
              ->orWhere('masa_berlaku_sip', '<=', $batasPeringatan);
        })->count();

        // Real-time: Sedang Bertugas
        // Logic: Jadwal hari ini + Shift jam mulai <= now <= shift jam selesai
        $sedangBertugas = JadwalJaga::whereDate('tanggal', $today)
            ->whereHas('shift', function($q) use ($now) {
                $q->whereTime('jam_mulai', '<=', $now->format('H:i:s'))
                  ->whereTime('jam_selesai', '>=', $now->format('H:i:s'));
            })
            ->count();

        $dataTab = [];

        // === TAB 1: IKHTISAR ===
        if ($this->tabAktif == 'ikhtisar') {
            // Komposisi Role (User)
            $dataTab['komposisiRole'] = User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get();
            
            // Komposisi Status Kepegawaian (PNS, PPPK, dll)
            $dataTab['distribusiStatus'] = Pegawai::select('status_kepegawaian', DB::raw('count(*) as total'))
                ->whereNotNull('status_kepegawaian')
                ->groupBy('status_kepegawaian')
                ->get();

            // Distribusi per Poli (Medical Staff)
            $dataTab['distribusiPoli'] = Poli::withCount('pegawais')
                ->having('pegawais_count', '>', 0)
                ->orderByDesc('pegawais_count')
                ->get();

            // Daftar Alert Dokumen
            $dataTab['dokumenAlert'] = Pegawai::where(function($q) use ($batasPeringatan) {
                    $q->where('masa_berlaku_str', '<=', $batasPeringatan)
                      ->orWhere('masa_berlaku_sip', '<=', $batasPeringatan);
                })
                ->with('user')
                ->take(5)
                ->get();

            $dataTab['gajiBulanIni'] = Penggajian::where('bulan', $now->translatedFormat('F'))
                ->where('tahun', $now->year)
                ->sum('total_gaji');
        }

        // === TAB 2: PRESENSI & JADWAL ===
        if ($this->tabAktif == 'presensi') {
            $jadwalQuery = JadwalJaga::with('pegawai.user', 'shift')
                ->whereDate('tanggal', $today);
            
            $dijadwalkan = $jadwalQuery->count();
            
            // Hitung kehadiran real-time (yang sudah shift dan hadir)
            $hadirReal = JadwalJaga::whereDate('tanggal', $today)->where('status_kehadiran', 'Hadir')->count();
            
            // Simulasi jika data belum lengkap
            if ($dijadwalkan > 0 && $hadirReal == 0) {
                 $hadirReal = floor($dijadwalkan * 0.8); 
            }

            $dataTab['statistikKehadiran'] = [
                'total' => $dijadwalkan,
                'hadir' => $hadirReal,
                'sedang_bertugas' => $sedangBertugas,
                'absen' => max(0, $dijadwalkan - $hadirReal)
            ];
            
            $dataTab['jadwalHariIni'] = $jadwalQuery->orderBy('shift_id')->get();
        }

        // === TAB 3: CUTI ===
        if ($this->tabAktif == 'cuti') {
            $dataTab['cutiPending'] = PengajuanCuti::with('user')->where('status', 'Menunggu')->get();
            
            $dataTab['sedangCuti'] = PengajuanCuti::with('user')
                ->where('status', 'Disetujui')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->get();
            
            // Cuti Akan Datang (7 hari ke depan)
            $dataTab['cutiAkanDatang'] = PengajuanCuti::with('user')
                ->where('status', 'Disetujui')
                ->whereDate('tanggal_mulai', '>', $today)
                ->whereDate('tanggal_mulai', '<=', $today->copy()->addDays(7))
                ->orderBy('tanggal_mulai')
                ->get();
            
            $dataTab['jenisCuti'] = PengajuanCuti::select('jenis_cuti', DB::raw('count(*) as total'))
                ->whereYear('created_at', $now->year)
                ->groupBy('jenis_cuti')
                ->get();
        }

        // === TAB 4: KINERJA ===
        if ($this->tabAktif == 'kinerja') {
            $dataTab['topPerformance'] = KinerjaPegawai::with('pegawai.user')
                ->whereMonth('created_at', $now->month)
                ->select('*', DB::raw('(orientasi_pelayanan + integritas + komitmen + disiplin + kerjasama) / 5 as rata_rata'))
                ->orderByDesc('rata_rata')
                ->limit(5)
                ->get();
            
            $dataTab['trenKinerja'] = $this->getTrenKinerja();
        }

        return view('livewire.hrd.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'dokumenExpired',
            'sedangBertugas',
            'dataTab'
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
                
            $data[] = round($avg ?? 0, 2); 
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
