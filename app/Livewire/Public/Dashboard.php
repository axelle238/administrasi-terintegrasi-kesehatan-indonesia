<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\Survey; // Asumsi ada model Survey Kepuasan
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Statistik Pengaduan
        $totalPengaduan = Pengaduan::count();
        $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $pengaduanProses = Pengaduan::where('status', 'Diproses')->count();
        $pengaduanPending = Pengaduan::where('status', 'Pending')->count();

        // 2. Kepuasan Masyarakat (IKM) - Mock jika belum ada
        // Asumsi nilai IKM 1-4 atau 1-100
        $ikmScore = 3.5; // Mock
        $totalResponden = 150; // Mock

        // 3. Pengaduan Terbaru
        $pengaduanTerbaru = Pengaduan::latest()->take(5)->get();

        // 4. Grafik Pengaduan Bulanan
        $grafikPengaduan = $this->getGrafikPengaduan();

        return view('livewire.public.dashboard', compact(
            'totalPengaduan',
            'pengaduanSelesai',
            'pengaduanProses',
            'pengaduanPending',
            'ikmScore',
            'totalResponden',
            'pengaduanTerbaru',
            'grafikPengaduan'
        ))->layout('layouts.app', ['header' => 'Dashboard Layanan Masyarakat']);
    }

    private function getGrafikPengaduan()
    {
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[] = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
