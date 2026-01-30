<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Pembayaran;
use App\Models\Penggajian;
use App\Models\PengadaanBarangDetail;
use App\Models\Pasien;
use App\Models\Tindakan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // Filter State
    public $periodeTahun;
    public $activeTab = 'ikhtisar'; // ikhtisar, pendapatan, pengeluaran, analitik

    public function mount()
    {
        $this->periodeTahun = date('Y');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // 1. KPI Pendapatan (Ikhtisar)
        $pendapatanHariIni = Pembayaran::whereDate('created_at', Carbon::today())->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanTahunIni = Pembayaran::whereYear('created_at', $this->periodeTahun)->where('status', 'Lunas')->sum('jumlah_bayar');

        // 2. Analisis Pengeluaran Detail
        $pengeluaranGajiBulan = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))->where('tahun', Carbon::now()->year)->sum('total_gaji');
        
        // FIX: Hitung total pengadaan dari tabel detail, join ke header untuk filter tanggal
        $pengeluaranBarangBulan = PengadaanBarangDetail::join('pengadaan_barangs', 'pengadaan_barang_details.pengadaan_barang_id', '=', 'pengadaan_barangs.id')
            ->whereMonth('pengadaan_barangs.tanggal_pengajuan', Carbon::now()->month)
            ->whereYear('pengadaan_barangs.tanggal_pengajuan', Carbon::now()->year)
            ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));

        $totalPengeluaranBulan = $pengeluaranGajiBulan + $pengeluaranBarangBulan;

        // 3. Margin Laba (Net Profit Simulation)
        $labaBersihBulan = $pendapatanBulanIni - $totalPengeluaranBulan;
        $rasioMargin = $pendapatanBulanIni > 0 ? ($labaBersihBulan / $pendapatanBulanIni) * 100 : 0;

        // 4. Analitik Pasien
        $totalPasienBulan = Pasien::whereMonth('created_at', Carbon::now()->month)->count();
        $rataTransaksiPasien = $totalPasienBulan > 0 ? $pendapatanBulanIni / $totalPasienBulan : 0;

        // 5. Data Grafik Kompleks (12 Bulan)
        $grafikData = $this->getGrafikKomprehensif();

        // 6. Distribusi Pendapatan per Poli (Top 5)
        $pendapatanPoli = DB::table('pembayarans')
            ->join('rekam_medis', 'pembayarans.rekam_medis_id', '=', 'rekam_medis.id')
            ->join('pegawais', 'rekam_medis.dokter_id', '=', 'pegawais.user_id')
            ->join('polis', 'pegawais.poli_id', '=', 'polis.id')
            ->select('polis.nama_poli', DB::raw('SUM(pembayarans.jumlah_bayar) as total'))
            ->whereMonth('pembayarans.created_at', Carbon::now()->month)
            ->groupBy('polis.nama_poli')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // 7. Transaksi Terakhir (Live)
        $transaksiTerakhir = Pembayaran::with(['pasien', 'kasir'])
            ->latest()
            ->take(8)
            ->get();

        // 8. Tunggakan / Pending (Piutang)
        $piutangPending = Pembayaran::where('status', 'Menunggu')->sum('jumlah_bayar');
        $piutangCount = Pembayaran::where('status', 'Menunggu')->count();

        return view('livewire.finance.dashboard', compact(
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pengeluaranGajiBulan',
            'pengeluaranBarangBulan',
            'totalPengeluaranBulan',
            'labaBersihBulan',
            'rasioMargin',
            'rataTransaksiPasien',
            'grafikData',
            'pendapatanPoli',
            'transaksiTerakhir',
            'piutangPending',
            'piutangCount'
        ))->layout('layouts.app', ['header' => 'Pusat Analitik Keuangan & Aset']);
    }

    private function getGrafikKomprehensif()
    {
        $labels = [];
        $income = [];
        $expense = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M');
            
            // Income
            $income[] = Pembayaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'Lunas')
                ->sum('jumlah_bayar');

            // Expense
            $gaji = Penggajian::where('bulan', $date->translatedFormat('F'))
                ->where('tahun', $date->year)
                ->sum('total_gaji');
            
            // FIX: Pengadaan Expense
            $barang = PengadaanBarangDetail::join('pengadaan_barangs', 'pengadaan_barang_details.pengadaan_barang_id', '=', 'pengadaan_barangs.id')
                ->whereMonth('pengadaan_barangs.tanggal_pengajuan', $date->month)
                ->whereYear('pengadaan_barangs.tanggal_pengajuan', $date->year)
                ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));
                
            $expense[] = $gaji + $barang;
        }

        return [
            'labels' => $labels,
            'income' => $income,
            'expense' => $expense
        ];
    }
}