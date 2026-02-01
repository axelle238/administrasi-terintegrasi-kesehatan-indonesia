<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Pembayaran;
use App\Models\Penggajian;
use App\Models\PengadaanBarangDetail;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // Filter State
    public $periodeTahun;
    public $tabAktif = 'ikhtisar'; // ikhtisar, pendapatan, pengeluaran, analitik

    public function mount()
    {
        $this->periodeTahun = date('Y');
    }

    public function aturTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function render()
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth();

        // 1. KPI Pendapatan (Ikhtisar)
        $pendapatanHariIni = Pembayaran::whereDate('created_at', $hariIni)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanTahunIni = Pembayaran::whereYear('created_at', $this->periodeTahun)->where('status', 'Lunas')->sum('jumlah_bayar');
        
        // Logika Pertumbuhan Bulanan (MoM Growth)
        $pendapatanBulanLalu = Pembayaran::whereMonth('created_at', $bulanLalu->month)->whereYear('created_at', $bulanLalu->year)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pertumbuhanBulanan = 0;
        if ($pendapatanBulanLalu > 0) {
            $pertumbuhanBulanan = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        } elseif ($pendapatanBulanIni > 0) {
            $pertumbuhanBulanan = 100;
        }

        // 2. Analisis Pengeluaran Detail
        $pengeluaranGajiBulan = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))->where('tahun', $tahunIni)->sum('total_gaji');
        
        // Hitung total pengadaan dari tabel detail
        $pengeluaranBarangBulan = PengadaanBarangDetail::join('pengadaan_barangs', 'pengadaan_barang_details.pengadaan_barang_id', '=', 'pengadaan_barangs.id')
            ->whereMonth('pengadaan_barangs.tanggal_pengajuan', $bulanIni)
            ->whereYear('pengadaan_barangs.tanggal_pengajuan', $tahunIni)
            ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));

        $totalPengeluaranBulan = $pengeluaranGajiBulan + $pengeluaranBarangBulan;

        // 3. Margin Laba
        $labaBersihBulan = $pendapatanBulanIni - $totalPengeluaranBulan;
        $rasioMargin = $pendapatanBulanIni > 0 ? ($labaBersihBulan / $pendapatanBulanIni) * 100 : 0;

        // 4. Analitik Pasien & Transaksi
        $totalPasienBulan = Pasien::whereMonth('created_at', $bulanIni)->count();
        $rataTransaksiPasien = $totalPasienBulan > 0 ? $pendapatanBulanIni / $totalPasienBulan : 0;

        // 5. Data Grafik Kompleks (12 Bulan)
        $dataGrafik = $this->dapatkanGrafikKomprehensif();

        // 6. Distribusi Pendapatan per Poli (Top 5)
        $pendapatanPoli = DB::table('pembayarans')
            ->join('rekam_medis', 'pembayarans.rekam_medis_id', '=', 'rekam_medis.id')
            ->join('pegawais', 'rekam_medis.dokter_id', '=', 'pegawais.user_id')
            ->join('polis', 'pegawais.poli_id', '=', 'polis.id')
            ->select('polis.nama_poli', DB::raw('SUM(pembayarans.jumlah_bayar) as total'))
            ->whereMonth('pembayarans.created_at', $bulanIni)
            ->groupBy('polis.nama_poli')
            ->orderByDesc('total')
            ->take(5)
            ->get();
            
        // 6b. Distribusi Sumber Pendapatan
        $sumberPendapatan = Pembayaran::whereMonth('pembayarans.created_at', $bulanIni)
            ->whereYear('pembayarans.created_at', $tahunIni)
            ->where('status', 'Lunas')
            ->select(
                DB::raw('SUM(total_biaya_tindakan) as tindakan'),
                DB::raw('SUM(total_biaya_obat) as obat'),
                DB::raw('SUM(biaya_administrasi) as administrasi')
            )->first();
            
        $distribusiPendapatan = [
            'labels' => ['Jasa Medis', 'Farmasi', 'Administrasi'],
            'data' => [
                (float) ($sumberPendapatan->tindakan ?? 0), 
                (float) ($sumberPendapatan->obat ?? 0), 
                (float) ($sumberPendapatan->administrasi ?? 0)
            ]
        ];

        // 6c. Analisis Metode Pembayaran (NEW)
        $metodePembayaran = Pembayaran::whereMonth('created_at', $bulanIni)
            ->select('metode_pembayaran', DB::raw('count(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        // 7. Transaksi Terakhir (Live)
        $transaksiTerakhir = Pembayaran::with(['pasien'])
            ->latest()
            ->take(8)
            ->get();

        // 8. Tunggakan / Pending (Piutang)
        $piutangPending = Pembayaran::where('status', 'Menunggu')->sum('jumlah_bayar');
        $piutangCount = Pembayaran::where('status', 'Menunggu')->count();

        // 9. Cost Per Patient (NEW)
        $costPerPatient = $totalPasienBulan > 0 ? $totalPengeluaranBulan / $totalPasienBulan : 0;

        return view('livewire.finance.dashboard', compact(
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pertumbuhanBulanan',
            'pengeluaranGajiBulan',
            'pengeluaranBarangBulan',
            'totalPengeluaranBulan',
            'labaBersihBulan',
            'rasioMargin',
            'rataTransaksiPasien',
            'dataGrafik',
            'pendapatanPoli',
            'distribusiPendapatan',
            'metodePembayaran',
            'transaksiTerakhir',
            'piutangPending',
            'piutangCount',
            'costPerPatient'
        ))->layout('layouts.app', ['header' => 'Pusat Analitik Keuangan & Aset']);
    }

    private function dapatkanGrafikKomprehensif()
    {
        $labels = [];
        $pendapatan = [];
        $pengeluaran = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M');
            
            // Pendapatan
            $pendapatan[] = Pembayaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'Lunas')
                ->sum('jumlah_bayar');

            // Pengeluaran
            $gaji = Penggajian::where('bulan', $date->translatedFormat('F'))
                ->where('tahun', $date->year)
                ->sum('total_gaji');
            
            $barang = PengadaanBarangDetail::join('pengadaan_barangs', 'pengadaan_barang_details.pengadaan_barang_id', '=', 'pengadaan_barangs.id')
                ->whereMonth('pengadaan_barangs.tanggal_pengajuan', $date->month)
                ->whereYear('pengadaan_barangs.tanggal_pengajuan', $date->year)
                ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));
                
            $pengeluaran[] = $gaji + $barang;
        }

        return [
            'labels' => $labels,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran
        ];
    }
}