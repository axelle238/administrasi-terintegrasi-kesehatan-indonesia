<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Maintenance;
use App\Models\PengadaanBarang;
use App\Models\RiwayatBarang;
use App\Models\Ruangan;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    #[Url(keep: true)]
    public $activeTab = 'ikhtisar'; // ikhtisar, stok, maintenance, pengadaan
    public $filterTipe = 'all'; // all, medis, umum

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function setFilterTipe($tipe)
    {
        $this->filterTipe = $tipe;
    }

    public function render()
    {
        // Base Query untuk Barang
        $barangQuery = Barang::query();

        if ($this->filterTipe == 'medis') {
            $barangQuery->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'like', '%Medis%')
                  ->orWhere('nama_kategori', 'like', '%Kesehatan%')
                  ->orWhere('nama_kategori', 'like', '%Alat%');
            });
        } elseif ($this->filterTipe == 'umum') {
            $barangQuery->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'not like', '%Medis%')
                  ->where('nama_kategori', 'not like', '%Kesehatan%')
                  ->where('nama_kategori', 'not like', '%Alat%');
            });
        }

        // === GLOBAL METRICS ===
        $totalAset = (clone $barangQuery)->count();
        // Nilai Aset (Estimasi Valuasi)
        $nilaiAsetTotal = (clone $barangQuery)->where('is_asset', true)->sum(DB::raw('harga_perolehan * stok'));
        
        // Kondisi Aset Stats (Filtered)
        $kondisiStats = [
            'Baik' => (clone $barangQuery)->where('kondisi', 'Baik')->count(),
            'PerluPerbaikan' => (clone $barangQuery)->where('kondisi', 'Rusak Ringan')->count(),
            'Rusak' => (clone $barangQuery)->where('kondisi', 'Rusak Berat')->count(),
        ];

        // Specific Metric for Medical: Kalibrasi Due
        $kalibrasiDue = 0;
        if ($this->filterTipe == 'medis' || $this->filterTipe == 'all') {
            $kalibrasiDue = Maintenance::whereHas('barang.kategori', function($q) {
                    $q->where('nama_kategori', 'like', '%Medis%');
                })
                ->where('jenis_kegiatan', 'Kalibrasi')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(60)) // Warning 2 bulan sebelum
                ->count();
        }

        $tabData = [];

        // === TAB 1: IKHTISAR ===
        if ($this->activeTab == 'ikhtisar') {
            $tabData['distribusiKategori'] = KategoriBarang::withCount(['barangs' => function($q) use ($barangQuery) {
                    // Filter count based on main filter logic
                    // Note: This needs refined logic if category structure is complex, 
                    // but for simple grouping, we rely on category name.
                }])
                ->orderByDesc('barangs_count')
                ->take(6)
                ->get();
            
            $tabData['recentActivities'] = RiwayatBarang::with(['barang', 'user'])
                ->whereHas('barang', function($q) use ($barangQuery) {
                    // Apply filter logic to relationship
                    if ($this->filterTipe == 'medis') {
                        $q->whereHas('kategori', fn($k) => $k->where('nama_kategori', 'like', '%Medis%'));
                    } elseif ($this->filterTipe == 'umum') {
                        $q->whereHas('kategori', fn($k) => $k->where('nama_kategori', 'not like', '%Medis%'));
                    }
                })
                ->latest()
                ->take(6)
                ->get();

            $tabData['lokasiAset'] = Ruangan::withCount('barangs') // Simplifikasi: Hitung semua barang di ruangan
                ->orderByDesc('barangs_count')
                ->take(5)
                ->get();
        }

        // === TAB 2: MONITORING STOK ===
        if ($this->activeTab == 'stok') {
            $tabData['lowStockItems'] = (clone $barangQuery)->where('is_asset', false) // Consumables / BHP
                ->where('stok', '<=', 10) // Alert Threshold
                ->orderBy('stok')
                ->take(10)
                ->get();
            
            // Grafik Arus Stok 7 Hari (Global Flow)
            $tabData['flowStok'] = $this->getStockFlow();
        }

        // === TAB 3: MAINTENANCE & KALIBRASI ===
        if ($this->activeTab == 'maintenance') {
            $maintenanceQuery = Maintenance::with(['barang.kategori'])
                ->where('status', 'Terjadwal')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(30));

            // Filter Maintenance based on Type
            if ($this->filterTipe != 'all') {
                $maintenanceQuery->whereHas('barang.kategori', function($q) {
                    if ($this->filterTipe == 'medis') {
                        $q->where('nama_kategori', 'like', '%Medis%');
                    } else {
                        $q->where('nama_kategori', 'not like', '%Medis%');
                    }
                });
            }

            $tabData['maintenanceDue'] = $maintenanceQuery->orderBy('tanggal_berikutnya')->get();
            
            // Analisis Biaya
            $tabData['biayaTrend'] = Maintenance::select(
                    DB::raw("DATE_FORMAT(tanggal_maintenance, '%Y-%m') as bulan"),
                    DB::raw("SUM(biaya) as total_biaya")
                )
                ->where('tanggal_maintenance', '>=', now()->subMonths(6))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $tabData['maintenanceRatio'] = [
                'preventif' => Maintenance::where('jenis_kegiatan', 'Preventif')->count(),
                'korektif' => Maintenance::where('jenis_kegiatan', 'Perbaikan')->count(),
                'kalibrasi' => Maintenance::where('jenis_kegiatan', 'Kalibrasi')->count(),
            ];
            
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
            'kalibrasiDue',
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
