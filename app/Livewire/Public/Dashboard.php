<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\Survey;
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

        // 2. Kepuasan Masyarakat (IKM) Real-time
        $ikmScore = Survey::avg('kepuasan') ?? 0; // Menggunakan kolom 'kepuasan'
        $totalResponden = Survey::count();

        // 3. Pengaduan Terbaru
        $pengaduanTerbaru = Pengaduan::latest()->take(5)->get();

        // 4. Grafik Pengaduan Bulanan
        $grafikPengaduan = $this->getGrafikPengaduan();

        // 5. Rata-rata Waktu Respon (Mock - Simulasi Sistem Tiket)
        $avgResponseTime = 24; 

        // 6. Kategori Pengaduan
        $topKategori = Pengaduan::select('subjek', DB::raw('count(*) as total'))
            ->groupBy('subjek')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // 7. Kanal Pengaduan (Simulasi Distribusi)
        $kanalPengaduan = [
            ['nama' => 'Website/Aplikasi', 'total' => floor($totalPengaduan * 0.6)],
            ['nama' => 'WhatsApp Center', 'total' => floor($totalPengaduan * 0.25)],
            ['nama' => 'Datang Langsung', 'total' => floor($totalPengaduan * 0.1)],
            ['nama' => 'Email Resmi', 'total' => $totalPengaduan - floor($totalPengaduan * 0.95)]
        ];

        return view('livewire.public.dashboard', compact(
            'totalPengaduan',
            'pengaduanSelesai',
            'pengaduanProses',
            'pengaduanPending',
            'ikmScore',
            'totalResponden',
            'pengaduanTerbaru',
            'grafikPengaduan',
            'avgResponseTime',
            'topKategori',
            'kanalPengaduan'
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