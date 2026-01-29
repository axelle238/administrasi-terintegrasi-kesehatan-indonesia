<?php

namespace App\Livewire\Medical;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Antrean;
use App\Models\Kamar;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    // State Management
    public $activeTab = 'ringkasan'; // ringkasan, demografi, klinis, rawat_inap

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // === GLOBAL METRICS (Always Loaded) ===
        $totalKunjunganHariIni = Antrean::whereDate('tanggal_antrean', Carbon::today())->count();
        $totalKunjunganBulanIni = Antrean::whereMonth('tanggal_antrean', Carbon::now()->month)->count();
        
        // BOR Calculation
        $bedTerisi = Kamar::sum('bed_terisi');
        $totalBed = Kamar::sum('kapasitas_bed');
        $bor = $totalBed > 0 ? ($bedTerisi / $totalBed) * 100 : 0;

        // Rata-rata Waktu Layanan (Simulasi/Kalkulasi)
        $avgWaktuLayanan = Antrean::whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Selesai')
            ->get()
            ->avg(function($item) {
                // Asumsi: updated_at adalah waktu selesai, created_at waktu daftar
                // Idealnya ada kolom 'waktu_mulai_layanan' dan 'waktu_selesai_layanan'
                return $item->updated_at->diffInMinutes($item->created_at);
            }) ?? 0;

        // === TAB DATA ===
        $tabData = [];

        if ($this->activeTab == 'ringkasan') {
            $tabData['trenKunjungan'] = $this->getTrenKunjungan();
            $tabData['poliActivity'] = Antrean::with('poli')
                ->whereDate('tanggal_antrean', Carbon::today())
                ->select('poli_id', DB::raw('count(*) as total'))
                ->groupBy('poli_id')
                ->get();
            $tabData['pasienBaru'] = Pasien::whereMonth('created_at', Carbon::now()->month)->count();
            $tabData['pasienLama'] = max(0, $totalKunjunganBulanIni - $tabData['pasienBaru']);
        }

        if ($this->activeTab == 'demografi') {
            // Gender Stats
            $tabData['genderStats'] = Pasien::select('jenis_kelamin', DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->get();
            
            // Age Distribution (Simulasi range umur dari tanggal_lahir)
            // SQLite/MySQL syntax differs for age calc, using PHP processing for compatibility safety in this context
            // or simple query if performant. Let's use simple grouping by year for rough estimate if needed, 
            // but for now let's stick to Payment Types which is more relevant for admin.
            
            $tabData['distribusiPembayaran'] = Antrean::join('pasiens', 'antreans.pasien_id', '=', 'pasiens.id')
                ->whereMonth('antreans.tanggal_antrean', Carbon::now()->month)
                ->select('pasiens.asuransi', DB::raw('count(*) as total'))
                ->groupBy('pasiens.asuransi')
                ->get();
        }

        if ($this->activeTab == 'klinis') {
            $tabData['topDiagnosa'] = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereNotNull('diagnosa')
                ->groupBy('diagnosa')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        }

        if ($this->activeTab == 'rawat_inap') {
            // Group by Kelas (assuming Kamar model has 'kelas' column, or we just list rooms)
            // Let's assume standard Kamar model structure
            $tabData['kamars'] = Kamar::orderBy('kelas')->get();
        }

        return view('livewire.medical.dashboard', compact(
            'totalKunjunganHariIni',
            'totalKunjunganBulanIni',
            'bedTerisi',
            'totalBed',
            'bor',
            'avgWaktuLayanan',
            'tabData'
        ))->layout('layouts.app', ['header' => 'Pusat Analitik Layanan Medis']);
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
