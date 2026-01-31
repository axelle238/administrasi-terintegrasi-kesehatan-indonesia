<?php

namespace App\Livewire\Ukm;

use Livewire\Component;
use App\Models\KegiatanUkm;
use App\Models\Pengaduan;
use App\Models\Pasien; // Asumsi untuk data sasaran masyarakat
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $filterTahun;
    
    public function mount()
    {
        $this->filterTahun = Carbon::now()->year;
    }

    public function render()
    {
        $now = Carbon::now();
        
        // --- 1. METRIK UTAMA (KPI) ---
        $totalKegiatanBulanIni = KegiatanUkm::whereMonth('tanggal_kegiatan', $now->month)
            ->whereYear('tanggal_kegiatan', $now->year)
            ->count();
            
        $totalPesertaBulanIni = KegiatanUkm::whereMonth('tanggal_kegiatan', $now->month)
            ->whereYear('tanggal_kegiatan', $now->year)
            ->sum('jumlah_peserta');
            
        // Target vs Realisasi (Simulasi target bulanan = 500 peserta)
        $targetPeserta = 500;
        $persentaseCapaian = $targetPeserta > 0 ? ($totalPesertaBulanIni / $targetPeserta) * 100 : 0;
        
        $kegiatanAkanDatang = KegiatanUkm::where('tanggal_kegiatan', '>', $now)->count();
        $pengaduanBaru = Pengaduan::where('status', 'Pending')->count();

        // --- 2. ANALISIS PROGRAM UKM ---
        // Mengelompokkan berdasarkan Program (KIA, Gizi, P2P, Promkes, Kesling)
        // Asumsi kolom 'nama_program' ada di tabel atau kita ambil dari 'nama_kegiatan'
        // Kita gunakan group by nama_kegiatan sementara jika belum ada tabel master program
        $performansiProgram = KegiatanUkm::select('nama_kegiatan', DB::raw('count(*) as frekuensi'), DB::raw('sum(jumlah_peserta) as total_peserta'))
            ->whereYear('tanggal_kegiatan', $now->year)
            ->groupBy('nama_kegiatan')
            ->orderByDesc('total_peserta')
            ->limit(5)
            ->get();

        // --- 3. TREN PARTISIPASI (6 Bulan) ---
        $bulanLabels = [];
        $pesertaData = [];
        $kegiatanData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            
            $pesertaData[] = (int) KegiatanUkm::whereYear('tanggal_kegiatan', $date->year)
                ->whereMonth('tanggal_kegiatan', $date->month)
                ->sum('jumlah_peserta');
                
            $kegiatanData[] = (int) KegiatanUkm::whereYear('tanggal_kegiatan', $date->year)
                ->whereMonth('tanggal_kegiatan', $date->month)
                ->count();
        }

        // --- 4. DATA PENGADUAN MASYARAKAT ---
        $kategoriPengaduan = Pengaduan::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();
            
        $aduanTerbaru = Pengaduan::latest()
            ->take(3)
            ->get();

        // --- 5. JADWAL KEGIATAN TERDEKAT ---
        $agendaMendatang = KegiatanUkm::where('tanggal_kegiatan', '>=', Carbon::today())
            ->orderBy('tanggal_kegiatan')
            ->take(4)
            ->get();

        return view('livewire.ukm.dashboard', [
            // KPI
            'totalKegiatan' => $totalKegiatanBulanIni,
            'totalPeserta' => $totalPesertaBulanIni,
            'persentaseCapaian' => $persentaseCapaian,
            'kegiatanAkanDatang' => $kegiatanAkanDatang,
            'pengaduanBaru' => $pengaduanBaru,
            
            // Charts & Tables
            'performansiProgram' => $performansiProgram,
            'chartLabels' => $bulanLabels,
            'pesertaData' => $pesertaData,
            'kegiatanData' => $kegiatanData,
            'kategoriPengaduan' => $kategoriPengaduan,
            
            // Lists
            'agendaMendatang' => $agendaMendatang,
            'aduanTerbaru' => $aduanTerbaru,
        ])->layout('layouts.app', ['header' => 'Pusat Analitik Kesehatan Masyarakat']);
    }
}