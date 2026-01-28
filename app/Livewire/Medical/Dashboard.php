<?php

namespace App\Livewire\Medical;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Antrean;
use App\Models\RawatInap;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Statistik Kunjungan
        $totalKunjunganHariIni = Antrean::whereDate('tanggal_antrean', Carbon::today())->count();
        $totalKunjunganBulanIni = Antrean::whereMonth('tanggal_antrean', Carbon::now()->month)->count();
        
        // 2. Demografi Pasien (Top 5 Diagnosa)
        $topDiagnosa = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereNotNull('diagnosa')
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 3. Okupansi Rawat Inap
        $bedTerisi = Kamar::sum('bed_terisi');
        $totalBed = Kamar::sum('kapasitas_bed');
        $bor = $totalBed > 0 ? ($bedTerisi / $totalBed) * 100 : 0; // Bed Occupancy Rate

        // 4. Aktivitas Poli Hari Ini
        $poliActivity = Antrean::with('poli')
            ->whereDate('tanggal_antrean', Carbon::today())
            ->select('poli_id', DB::raw('count(*) as total'))
            ->groupBy('poli_id')
            ->get();

        // 5. Tren Kunjungan 7 Hari Terakhir
        $trenKunjungan = $this->getTrenKunjungan();

        // 6. Pasien Baru vs Lama (Bulan Ini)
        // Asumsi sederhana: Pasien created_at bulan ini = baru
        $pasienBaru = Pasien::whereMonth('created_at', Carbon::now()->month)->count();
        $pasienLama = $totalKunjunganBulanIni - $pasienBaru; // Aproksimasi

        return view('livewire.medical.dashboard', compact(
            'totalKunjunganHariIni',
            'totalKunjunganBulanIni',
            'topDiagnosa',
            'bedTerisi',
            'totalBed',
            'bor',
            'poliActivity',
            'trenKunjungan',
            'pasienBaru',
            'pasienLama'
        ))->layout('layouts.app', ['header' => 'Dashboard Layanan Medis']);
    }

    private function getTrenKunjungan()
    {
        $data = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Antrean::whereDate('tanggal_antrean', $date)->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
