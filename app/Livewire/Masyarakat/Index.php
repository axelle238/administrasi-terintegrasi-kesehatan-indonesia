<?php

namespace App\Livewire\Masyarakat;

use Livewire\Component;
use App\Models\KegiatanUkm;
use App\Models\Survey;
use App\Models\Pengaduan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // 1. Statistik Utama
        $totalKegiatan = KegiatanUkm::count();
        $totalPengaduan = Pengaduan::count();
        $pengaduanPending = Pengaduan::where('status', 'Pending')->count();
        $totalResponden = Survey::count();
        
        // Hitung Indeks Kepuasan Masyarakat (Rata-rata rating 1-5 dikonversi ke skala 100)
        // Asumsi kolom 'rating' ada di tabel surveys. Jika tidak, perlu disesuaikan.
        // Cek struktur Survey nanti, sementara asumsi ada.
        $avgRating = Survey::avg('rating_layanan') ?? 0; // Skala 5
        $ikmScore = ($avgRating / 5) * 100;

        // 2. Daftar Pengaduan Terbaru
        $pengaduanTerbaru = Pengaduan::latest()
            ->take(5)
            ->get();

        // 3. Kegiatan UKM (Searchable)
        $kegiatans = KegiatanUkm::where('nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orWhere('lokasi', 'like', '%' . $this->search . '%')
            ->latest('tanggal_kegiatan')
            ->paginate(6);

        // 4. Grafik Tren Kepuasan (6 Bulan)
        $trenKepuasan = $this->getTrenKepuasan();

        return view('livewire.masyarakat.index', compact(
            'totalKegiatan',
            'totalPengaduan',
            'pengaduanPending',
            'totalResponden',
            'ikmScore',
            'pengaduanTerbaru',
            'kegiatans',
            'trenKepuasan'
        ))->layout('layouts.app', ['header' => 'Dashboard Pelayanan Publik']);
    }

    private function getTrenKepuasan()
    {
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $avg = Survey::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->avg('rating_layanan');
                
            $data[] = round($avg ?? 0, 1);
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
