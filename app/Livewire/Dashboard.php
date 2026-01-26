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
use App\Models\Maintenance;
use App\Models\Penggajian;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // Mengatur ambang batas peringatan dini (Early Warning System)
        $bulanAmbangBatas = (int) (Setting::ambil('ews_threshold_month', 3));
        $batasPeringatan = Carbon::now()->addMonths($bulanAmbangBatas);

        // Keuangan Hari Ini & Bulan Ini
        $pendapatanHariIni = Pembayaran::whereDate('created_at', Carbon::today())->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('status', 'Lunas')->sum('jumlah_bayar');
        
        // Pengeluaran Gaji Bulan Ini
        $pengeluaranGaji = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))
            ->where('tahun', Carbon::now()->year)
            ->sum('total_gaji');

        return view('livewire.dashboard', [
            // Statistik Utama
            'totalPasien' => Pasien::count(),
            'antreanHariIni' => Antrean::whereDate('tanggal_antrean', Carbon::today())->count(),
            'pasienRawatInap' => RawatInap::where('status', 'Aktif')->count(),
            'kamarTersedia' => Kamar::where('status', 'Tersedia')->count(),
            
            // Logistik & Aset
            'obatMenipis' => Obat::whereColumn('stok', '<=', 'min_stok')->count(),
            'asetMaintenance' => Maintenance::whereDate('tanggal_berikutnya', '<=', Carbon::now()->addDays(7))
                                    ->where('status', 'Terjadwal')
                                    ->count(),

            // Administrasi
            'suratMasuk' => Surat::where('jenis_surat', 'Masuk')->count(),
            
            // Keuangan Ringkas
            'pendapatanHariIni' => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pengeluaranGaji' => $pengeluaranGaji,

            // Variabel Sistem Peringatan Dini (EWS) - HR & Farmasi
            'strExpired' => Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)->count(),
            'sipExpired' => Pegawai::where('masa_berlaku_sip', '<=', $batasPeringatan)->count(),
            'obatExpired' => Obat::where('tanggal_kedaluwarsa', '<=', $batasPeringatan)->count(),

            // Data Grafik Visual
            'dataGrafik' => $this->ambilDataGrafik(), 
            'dataPendapatan' => $this->ambilDataPendapatan(),
        ])->layout('layouts.app', ['header' => 'Pusat Komando & Informasi']);
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