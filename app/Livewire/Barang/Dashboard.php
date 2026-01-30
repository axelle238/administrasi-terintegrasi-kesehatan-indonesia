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
        // Nilai Aset (Estimasi Valuasi)
        $nilaiAsetTotal = Barang::where('is_asset', true)->sum(DB::raw('harga_perolehan * stok'));
        
        // Alat Kesehatan (Alkes) Specific Metric
        $totalAlkes = Barang::whereHas('kategori', function($q) {
            $q->where('nama_kategori', 'like', '%Medis%')
              ->orWhere('nama_kategori', 'like', '%Kesehatan%')
              ->orWhere('nama_kategori', 'like', '%Alat%');
        })->count();

        // Kondisi Aset Stats
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
            $tabData['lowStockItems'] = Barang::where('is_asset', false) // Consumables / BHP
                ->where('stok', '<=', 10) // Alert Threshold
                ->orderBy('stok')
                ->take(10)
                ->get();
            
            // Grafik Arus Stok 7 Hari
            $tabData['flowStok'] = $this->getStockFlow();
        }

        // === TAB 3: MAINTENANCE & KALIBRASI ===
        if ($this->activeTab == 'maintenance') {
            // Semua Maintenance Terjadwal
            $maintenanceQuery = Maintenance::with(['barang.kategori'])
                ->where('status', 'Terjadwal')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(30)); // 30 hari kedepan

            // Prioritaskan Alkes
            $tabData['maintenanceDue'] = $maintenanceQuery->get()->sortBy(function($m) {
                $isAlkes = str_contains(strtolower($m->barang->kategori->nama_kategori ?? ''), 'medis');
                return $isAlkes ? 0 : 1; // Alkes first
            });
            
            $tabData['biayaMaintenanceBulanIni'] = Maintenance::whereMonth('tanggal_maintenance', Carbon::now()->month)
                ->whereYear('tanggal_maintenance', Carbon::now()->year)
                ->sum('biaya');
        }

        // === TAB 4: PENGADAAN ===
        if ($this->activeTab == 'pengadaan') {
            $tabData['pengadaanPending'] = PengadaanBarang::where('status', 'Pending')->latest()->get();
            $tabData['totalPengadaanTahunIni'] = PengadaanBarang::whereYear('tanggal_pengadaan', Carbon::now()->year)
                ->where('status', 'Selesai')
                ->sum('total_harga');
        }

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAsetTotal',
            'totalAlkes',
            'kondisiStats',
            'tabData'
        ))->layout('layouts.app', ['header' => 'Manajemen Aset & Inventaris']);
    }

    private function getStockFlow()
    {
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
