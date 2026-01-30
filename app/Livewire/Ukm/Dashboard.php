<?php

namespace App\Livewire\Ukm;

use Livewire\Component;
use App\Models\KegiatanUkm;
use App\Models\Pengaduan;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Statistik Utama
        $totalKegiatanBulanIni = KegiatanUkm::whereMonth('tanggal_kegiatan', Carbon::now()->month)->count();
        $totalPesertaBulanIni = KegiatanUkm::whereMonth('tanggal_kegiatan', Carbon::now()->month)->sum('jumlah_peserta');
        $kegiatanAkanDatang = KegiatanUkm::where('tanggal_kegiatan', '>', Carbon::now())->count();
        $pengaduanBaru = Pengaduan::where('status', 'Pending')->count();

        // 2. Grafik Tren Peserta (6 bulan terakhir)
        $bulanLabels = [];
        $pesertaData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            $pesertaData[] = (int) KegiatanUkm::whereYear('tanggal_kegiatan', $date->year)
                ->whereMonth('tanggal_kegiatan', $date->month)
                ->sum('jumlah_peserta');
        }

        // 3. Kegiatan Terdekat
        $upcomingEvents = KegiatanUkm::where('tanggal_kegiatan', '>=', Carbon::today())
            ->orderBy('tanggal_kegiatan')
            ->take(5)
            ->get();

        return view('livewire.ukm.dashboard', [
            'totalKegiatan' => $totalKegiatanBulanIni,
            'totalPeserta' => $totalPesertaBulanIni,
            'kegiatanAkanDatang' => $kegiatanAkanDatang,
            'pengaduanBaru' => $pengaduanBaru,
            'chartLabels' => $bulanLabels,
            'chartData' => $pesertaData,
            'upcomingEvents' => $upcomingEvents,
        ])->layout('layouts.app', ['header' => 'Dashboard Kesehatan Masyarakat']);
    }
}
