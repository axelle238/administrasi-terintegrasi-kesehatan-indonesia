<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Pembayaran;
use App\Models\Penggajian;
use App\Models\PengadaanBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Ringkasan Pendapatan
        $pendapatanHariIni = Pembayaran::whereDate('created_at', Carbon::today())->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', Carbon::now()->month)->where('status', 'Lunas')->sum('jumlah_bayar');
        $pendapatanTahunIni = Pembayaran::whereYear('created_at', Carbon::now()->year)->where('status', 'Lunas')->sum('jumlah_bayar');

        // 2. Ringkasan Pengeluaran (Gaji + Pengadaan)
        $pengeluaranGajiBulan = Penggajian::where('bulan', Carbon::now()->translatedFormat('F'))->where('tahun', Carbon::now()->year)->sum('total_gaji');
        $pengeluaranBarang = PengadaanBarang::whereMonth('tanggal_pengadaan', Carbon::now()->month)->whereYear('tanggal_pengadaan', Carbon::now()->year)->sum('total_harga');
        $totalPengeluaranBulan = $pengeluaranGajiBulan + $pengeluaranBarang;

        // 3. Proyeksi & Rata-rata
        $hariBerjalan = Carbon::now()->day;
        $rataRataHarian = $hariBerjalan > 0 ? $pendapatanBulanIni / $hariBerjalan : 0;
        $proyeksiAkhirBulan = $rataRataHarian * Carbon::now()->daysInMonth;

        // 4. Grafik Komparasi Keuangan (Pendapatan vs Pengeluaran)
        $grafikKeuangan = $this->getGrafikKeuangan();

        // 5. Metode Pembayaran Terpopuler
        $metodeBayar = Pembayaran::select('metode_pembayaran', DB::raw('count(*) as total'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('metode_pembayaran')
            ->get();

        // 6. Transaksi Terakhir (Live Feed)
        $transaksiTerakhir = Pembayaran::with(['pasien', 'kasir'])
            ->where('status', 'Lunas')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.finance.dashboard', compact(
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pengeluaranGajiBulan',
            'pengeluaranBarang',
            'totalPengeluaranBulan',
            'rataRataHarian',
            'proyeksiAkhirBulan',
            'grafikKeuangan',
            'metodeBayar',
            'transaksiTerakhir'
        ))->layout('layouts.app', ['header' => 'Dashboard Keuangan']);
    }

    private function getGrafikKeuangan()
    {
        $labels = [];
        $pendapatan = [];
        $pengeluaran = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            // Pendapatan
            $pendapatan[] = Pembayaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'Lunas')
                ->sum('jumlah_bayar');

            // Pengeluaran (Gaji + Pengadaan)
            $gaji = Penggajian::where('bulan', $date->translatedFormat('F'))
                ->where('tahun', $date->year)
                ->sum('total_gaji');
            
            $barang = PengadaanBarang::whereYear('tanggal_pengadaan', $date->year)
                ->whereMonth('tanggal_pengadaan', $date->month)
                ->sum('total_harga');

            $pengeluaran[] = $gaji + $barang;
        }

        return [
            'labels' => $labels, 
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran
        ];
    }
}