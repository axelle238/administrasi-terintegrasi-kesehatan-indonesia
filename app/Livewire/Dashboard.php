<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\Antrean;
use App\Models\Obat;
use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\RekamMedis;
use App\Models\RawatInap;
use App\Models\Kamar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // Mengatur ambang batas peringatan dini (Early Warning System)
        $bulanAmbangBatas = (int) ($this->app_settings['ews_threshold_month'] ?? 3);
        $batasPeringatan = Carbon::now()->addMonths($bulanAmbangBatas);

        return view('livewire.dashboard', [
            'totalPasien' => Pasien::count(),
            'antreanHariIni' => Antrean::whereDate('tanggal_antrean', Carbon::today())->count(),
            'obatMenipis' => Obat::whereColumn('stok', '<=', 'min_stok')->count(),
            'suratMasuk' => Surat::where('jenis_surat', 'Masuk')->count(),
            'pasienRawatInap' => RawatInap::where('status', 'Aktif')->count(),
            'kamarTersedia' => Kamar::where('status', 'Tersedia')->count(),
            
            // Variabel Sistem Peringatan Dini (EWS)
            'strExpired' => Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)->count(),
            'sipExpired' => Pegawai::where('masa_berlaku_sip', '<=', $batasPeringatan)->count(),
            'obatExpired' => Obat::where('tanggal_kedaluwarsa', '<=', $batasPeringatan)->count(),

            // Data Statistik
            'dataGrafik' => $this->ambilDataGrafik(), 
            'dataPendapatan' => $this->ambilDataPendapatan(),
        ])->layout('layouts.app', ['header' => 'Ringkasan Sistem']);
    }

    private function ambilDataGrafik() {
        $bulan = [];
        $dataKunjungan = [];
        for ($i = 5; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subMonths($i);
            $bulan[] = $tanggal->translatedFormat('M Y');
            $dataKunjungan[] = RekamMedis::whereYear('created_at', $tanggal->year)
                ->whereMonth('created_at', $tanggal->month)
                ->count();
        }
        return [
            'labels' => $bulan,
            'data' => $dataKunjungan,
        ];
    }

    private function ambilDataPendapatan() {
        $hari = [];
        $pendapatan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $hari[] = $tanggal->translatedFormat('D, d M');
            $pendapatan[] = Pembayaran::whereDate('created_at', $tanggal)
                ->where('status', 'Lunas')
                ->sum('jumlah_bayar');
        }
        return [
            'labels' => $hari,
            'data' => $pendapatan,
        ];
    }
}