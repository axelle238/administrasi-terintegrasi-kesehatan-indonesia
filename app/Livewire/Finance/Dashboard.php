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
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();

        // 1. KPI Pendapatan (Ikhtisar)
        $pendapatanHariIni = Pembayaran::whereDate('created_at', $today)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanTahunIni = Pembayaran::whereYear('created_at', $this->periodeTahun)->where('status', 'Lunas')->sum('jumlah_bayar');
        
        // MoM Growth Logic
        $pendapatanBulanLalu = Pembayaran::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->where('status', 'Lunas')->sum('jumlah_bayar');
        $growthMoM = 0;
        if ($pendapatanBulanLalu > 0) {
            $growthMoM = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        } elseif ($pendapatanBulanIni > 0) {
            $growthMoM = 100;
        }

        // 2. Analisis Pengeluaran Detail
        $pengeluaranGajiBulan = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))->where('tahun', $thisYear)->sum('total_gaji');
        
        // Hitung total pengadaan dari tabel detail, join ke header untuk filter tanggal
        $pengeluaranBarangBulan = PengadaanBarangDetail::join('pengadaan_barangs', 'pengadaan_barang_details.pengadaan_barang_id', '=', 'pengadaan_barangs.id')
            ->whereMonth('pengadaan_barangs.tanggal_pengajuan', $thisMonth)
            ->whereYear('pengadaan_barangs.tanggal_pengajuan', $thisYear)
            ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));

        $totalPengeluaranBulan = $pengeluaranGajiBulan + $pengeluaranBarangBulan;

        // 3. Margin Laba (Net Profit Simulation)
        $labaBersihBulan = $pendapatanBulanIni - $totalPengeluaranBulan;
        $rasioMargin = $pendapatanBulanIni > 0 ? ($labaBersihBulan / $pendapatanBulanIni) * 100 : 0;

        // 4. Analitik Pasien & Transaksi
        $totalPasienBulan = Pasien::whereMonth('created_at', $thisMonth)->count();
        $rataTransaksiPasien = $totalPasienBulan > 0 ? $pendapatanBulanIni / $totalPasienBulan : 0;

        // 5. Data Grafik Kompleks (12 Bulan)
        $grafikData = $this->getGrafikKomprehensif();

        // 6. Distribusi Pendapatan per Poli (Top 5)
        $pendapatanPoli = DB::table('pembayarans')
            ->join('rekam_medis', 'pembayarans.rekam_medis_id', '=', 'rekam_medis.id')
            ->join('pegawais', 'rekam_medis.dokter_id', '=', 'pegawais.user_id')
            ->join('polis', 'pegawais.poli_id', '=', 'polis.id')
            ->select('polis.nama_poli', DB::raw('SUM(pembayarans.jumlah_bayar) as total'))
            ->whereMonth('pembayarans.created_at', $thisMonth)
            ->groupBy('polis.nama_poli')
            ->orderByDesc('total')
            ->take(5)
            ->get();
            
        // 6b. Distribusi Sumber Pendapatan (Obat vs Tindakan vs Admin)
        $sumberPendapatan = Pembayaran::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
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

        // 7. Transaksi Terakhir (Live)
        $transaksiTerakhir = Pembayaran::with(['pasien'])
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
            'growthMoM',
            'pengeluaranGajiBulan',
            'pengeluaranBarangBulan',
            'totalPengeluaranBulan',
            'labaBersihBulan',
            'rasioMargin',
            'rataTransaksiPasien',
            'grafikData',
            'pendapatanPoli',
            'distribusiPendapatan',
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
