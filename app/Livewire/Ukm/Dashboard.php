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
            
        // --- 6. IKM & SURVEILANS (NEW) ---
        $rataRataIKM = \App\Models\Survey::whereMonth('created_at', $now->month)->avg('nilai');
        // Asumsi Nilai 1-4 dikonversi ke Skala 100 (Permenpan RB)
        $skorIKM = $rataRataIKM ? ($rataRataIKM / 4) * 100 : 0;
        $totalResponden = \App\Models\Survey::whereMonth('created_at', $now->month)->count();

        $penyakitTerbanyak = \App\Models\RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
            ->whereMonth('created_at', $now->month)
            ->whereNotNull('diagnosa')
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // --- 7. EARLY WARNING SYSTEM (EWS) & RISIKO WILAYAH ---
        // Deteksi lonjakan kasus (threshold simpel: > 5 kasus/bulan untuk penyakit menular tertentu)
        $penyakitPotensiWabah = ['Deman Berdarah', 'Diare', 'TBC', 'Covid-19', 'Campak'];
        $ewsAlerts = \App\Models\RekamMedis::whereIn('diagnosa', $penyakitPotensiWabah)
            ->whereMonth('created_at', $now->month)
            ->select('diagnosa', DB::raw('count(*) as total'))
            ->groupBy('diagnosa')
            ->having('total', '>=', 2) // Threshold rendah untuk demo
            ->get();

        // Simulasi Risiko Wilayah (Agregasi dari Alamat Pasien)
        $risikoWilayah = Pasien::select('alamat', DB::raw('count(*) as total_pasien')) // Asumsi alamat = Desa/Kelurahan
            ->join('rekam_medis', 'pasiens.id', '=', 'rekam_medis.pasien_id')
            ->whereMonth('rekam_medis.created_at', $now->month)
            ->groupBy('alamat')
            ->orderByDesc('total_pasien')
            ->limit(6)
            ->get()
            ->map(function($item) {
                // Tentukan status berdasarkan jumlah kasus
                if ($item->total_pasien > 10) $item->status = 'Merah'; // Risiko Tinggi
                elseif ($item->total_pasien > 5) $item->status = 'Kuning'; // Waspada
                else $item->status = 'Hijau'; // Aman
                return $item;
            });

        return view('livewire.ukm.dashboard', [
            // KPI
            'totalKegiatan' => $totalKegiatanBulanIni,
            'totalPeserta' => $totalPesertaBulanIni,
            'persentaseCapaian' => $persentaseCapaian,
            'kegiatanAkanDatang' => $kegiatanAkanDatang,
            'pengaduanBaru' => $pengaduanBaru,
            
            // IKM & Surveilans
            'skorIKM' => $skorIKM,
            'totalResponden' => $totalResponden,
            'penyakitTerbanyak' => $penyakitTerbanyak,
            
            // EWS & Wilayah
            'ewsAlerts' => $ewsAlerts,
            'risikoWilayah' => $risikoWilayah,

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