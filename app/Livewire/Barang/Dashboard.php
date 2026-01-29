<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Maintenance;
use App\Models\PengadaanBarang;
use App\Models\RiwayatBarang;
use App\Models\Ruangan;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $activeTab = 'ikhtisar'; // ikhtisar, stok, maintenance, pengadaan

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // === GLOBAL METRICS ===
        $totalAset = Barang::count();
        $nilaiAsetTotal = Barang::where('is_asset', true)->sum(DB::raw('harga_perolehan * stok')); // Asumsi simplified valuation
        
        // Kondisi Aset
        $kondisiStats = [
            'Baik' => Barang::where('kondisi', 'Baik')->count(),
            'PerluPerbaikan' => Barang::where('kondisi', 'Rusak Ringan')->count(),
            'Rusak' => Barang::where('kondisi', 'Rusak Berat')->count(),
        ];

        $tabData = [];

        // === TAB 1: IKHTISAR ===
        if ($this->activeTab == 'ikhtisar') {
            $tabData['distribusiKategori'] = KategoriBarang::withCount('barangs')
                ->orderByDesc('barangs_count')
                ->take(6)
                ->get();
            
            $tabData['recentActivities'] = RiwayatBarang::with(['barang', 'user'])
                ->latest()
                ->take(6)
                ->get();

            $tabData['lokasiAset'] = Ruangan::withCount('barangs')
                ->orderByDesc('barangs_count')
                ->take(5)
                ->get();
        }

        // === TAB 2: MONITORING STOK ===
        if ($this->activeTab == 'stok') {
            $tabData['lowStockItems'] = Barang::where('is_asset', false) // Consumables only
                ->where('stok', '<=', 10) // Threshold warning
                ->orderBy('stok')
                ->get();
            
            // Barang Masuk vs Keluar (7 Hari Terakhir) - Simulasi via Riwayat
            $tabData['flowStok'] = $this->getStockFlow();
        }

        // === TAB 3: MAINTENANCE & KALIBRASI ===
        if ($this->activeTab == 'maintenance') {
            $tabData['maintenanceDue'] = Maintenance::with('barang')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(14))
                ->whereDate('tanggal_berikutnya', '>=', now())
                ->orderBy('tanggal_berikutnya')
                ->get();
            
            $tabData['biayaMaintenanceBulanIni'] = Maintenance::whereMonth('tanggal_maintenance', Carbon::now()->month)
                ->sum('biaya');
        }

        // === TAB 4: PENGADAAN ===
        if ($this->activeTab == 'pengadaan') {
            $tabData['pengadaanPending'] = PengadaanBarang::where('status', 'Pending')->get();
            $tabData['totalPengadaanTahunIni'] = PengadaanBarang::whereYear('tanggal_pengadaan', Carbon::now()->year)
                ->where('status', 'Selesai')
                ->sum('total_harga');
        }

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAsetTotal',
            'kondisiStats',
            'tabData'
        ))->layout('layouts.app', ['header' => 'Manajemen Aset & Inventaris']);
    }

    private function getStockFlow()
    {
        // Logika grafik sederhana Masuk vs Keluar
        $dates = [];
        $in = [];
        $out = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('d/m');
            
            $in[] = RiwayatBarang::whereDate('tanggal', $date)
                ->whereIn('jenis_transaksi', ['Masuk', 'Pengadaan', 'Pembelian'])
                ->sum('jumlah');
                
            $out[] = RiwayatBarang::whereDate('tanggal', $date)
                ->whereIn('jenis_transaksi', ['Keluar', 'Mutasi Keluar', 'Pemakaian'])
                ->sum('jumlah');
        }

        return ['labels' => $dates, 'in' => $in, 'out' => $out];
    }
}