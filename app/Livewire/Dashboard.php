<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\Antrean;
use App\Models\Obat;
use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\JadwalJaga;
use App\Models\RekamMedis;
use App\Models\RawatInap;
use App\Models\Kamar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // ... (Geolocation constants)

    public $lat;
    public $lng;

    // ... (clockIn and calculateDistance methods remain same)

    public function render()
    {
        $thresholdMonths = (int) ($this->app_settings['ews_threshold_month'] ?? 3);
        $warningThreshold = Carbon::now()->addMonths($thresholdMonths);

        return view('livewire.dashboard', [
            'totalPasien' => Pasien::count(),
            'antreanHariIni' => Antrean::whereDate('tanggal_antrean', Carbon::today())->count(),
            'obatMenipis' => Obat::whereColumn('stok', '<=', 'min_stok')->count(),
            'suratMasuk' => Surat::where('jenis_surat', 'Masuk')->count(),
            'pasienRawatInap' => RawatInap::where('status', 'Aktif')->count(),
            'kamarTersedia' => Kamar::where('status', 'Tersedia')->count(),
            
            // EWS Variables
            'strExpired' => Pegawai::where('masa_berlaku_str', '<=', $warningThreshold)->count(),
            'sipExpired' => Pegawai::where('masa_berlaku_sip', '<=', $warningThreshold)->count(),
            'obatExpired' => Obat::where('tanggal_kedaluwarsa', '<=', $warningThreshold)->count(),

            'chartData' => $this->getChartData(), 
            'revenueData' => $this->getRevenueData(),
        ])->layout('layouts.app', ['header' => 'Dashboard']);
    }

    private function getChartData() {
        $months = [];
        $visitData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $visitData[] = RekamMedis::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return [
            'labels' => $months,
            'data' => $visitData,
        ];
    }

    private function getRevenueData() {
        $days = [];
        $income = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->translatedFormat('D, d M');
            $income[] = Pembayaran::whereDate('created_at', $date)
                ->where('status', 'Lunas')
                ->sum('jumlah_bayar');
        }
        return [
            'labels' => $days,
            'data' => $income,
        ];
    }
}