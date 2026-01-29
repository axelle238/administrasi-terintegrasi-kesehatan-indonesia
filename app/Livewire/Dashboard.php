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
use App\Models\Pengaduan;
use App\Models\Poli;
use App\Models\Fasilitas;
use App\Models\Berita;
use App\Models\RiwayatLogin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // Mengatur ambang batas peringatan dini (Early Warning System)
        $bulanAmbangBatas = (int) (Setting::ambil('ews_threshold_month', 3));
        $batasPeringatan = Carbon::now()->addMonths($bulanAmbangBatas);

        // --- SECTION 1: KEUANGAN ---
        $pendapatanHariIni = Pembayaran::whereDate('created_at', Carbon::today())->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pengeluaranGaji = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))->where('tahun', Carbon::now()->year)->sum('total_gaji');
        
        // --- SECTION 2: OPERASIONAL MEDIS ---
        // Statistik Poli Hari Ini
        $kunjunganPoli = Antrean::whereDate('tanggal_antrean', Carbon::today())
            ->select('poli_id', DB::raw('count(*) as total'))
            ->groupBy('poli_id')
            ->with('poli')
            ->get();

        // Ketersediaan Kamar Rawat Inap per Bangsal
        $ketersediaanBed = Kamar::select('nama_bangsal', DB::raw('sum(kapasitas_bed) as total_kapasitas'), DB::raw('sum(bed_terisi) as total_terisi'))
            ->groupBy('nama_bangsal')
            ->get();

        // Top 5 Penyakit Bulan Ini
        $topPenyakit = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereNotNull('diagnosa')
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Rata-rata Waktu Layanan (Simulasi/Sederhana)
        $avgWaktuLayanan = Antrean::whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Selesai')
            ->get()
            ->avg(function($antrean) {
                return $antrean->updated_at->diffInMinutes($antrean->created_at);
            }) ?? 0;

        // Login Gagal Hari Ini (Indikator Keamanan)
        $loginGagal = RiwayatLogin::whereDate('created_at', Carbon::today())->where('status', 'Gagal')->count();

        return view('livewire.dashboard', [
            // Statistik Utama Global
            'totalPasien' => Pasien::count(),
            'pasienBaruBulanIni' => Pasien::whereMonth('created_at', Carbon::now()->month)->count(),
            'antreanHariIni' => Antrean::whereDate('tanggal_antrean', Carbon::today())->count(),
            'antreanSelesai' => Antrean::whereDate('tanggal_antrean', Carbon::today())->where('status', 'Selesai')->count(),
            'pasienRawatInap' => RawatInap::where('status', 'Aktif')->count(),
            'kamarTersedia' => Kamar::where('status', 'Tersedia')->count(),
            
            // Logistik & Aset & EWS
            'obatMenipis' => Obat::whereColumn('stok', '<=', 'min_stok')->count(),
            'asetMaintenance' => Maintenance::whereDate('tanggal_berikutnya', '<=', Carbon::now()->addDays(7))->where('status', 'Terjadwal')->count(),
            'strExpired' => Pegawai::where('masa_berlaku_str', '<=', $batasPeringatan)->count(),
            'sipExpired' => Pegawai::where('masa_berlaku_sip', '<=', $batasPeringatan)->count(),
            'obatExpired' => Obat::where('tanggal_kedaluwarsa', '<=', $batasPeringatan)->count(),

            // Administrasi & Masyarakat
            'suratMasuk' => Surat::where('jenis_surat', 'Masuk')->count(),
            'suratKeluar' => Surat::where('jenis_surat', 'Keluar')->count(),
            'pengaduanPending' => Pengaduan::where('status', 'Pending')->count(),
            'pengaduanProses' => Pengaduan::where('status', 'Diproses')->count(),
            
            // Konten Publik
            'fasilitasAktif' => Fasilitas::where('is_active', true)->count(),
            'beritaPublished' => Berita::where('status', 'published')->count(),
            'loginGagal' => $loginGagal,

            // Keuangan Ringkas
            'pendapatanHariIni' => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pengeluaranGaji' => $pengeluaranGaji,

            // Data Visual & Detail
            'kunjunganPoli' => $kunjunganPoli,
            'ketersediaanBed' => $ketersediaanBed,
            'topPenyakit' => $topPenyakit,
            'avgWaktuLayanan' => round($avgWaktuLayanan),
            'dataGrafik' => $this->ambilDataGrafik(), 
            'dataPendapatan' => $this->ambilDataPendapatan(),
        ])->layout('layouts.app', ['header' => 'Pusat Komando & Eksekutif Dashboard']);
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