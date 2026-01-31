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
    public $tabAktif = 'ikhtisar'; // ikhtisar, stok, maintenance, pengadaan

    #[Url(keep: true)]
    public $tipeFilter = 'all'; // all, medis, umum

    public function aturTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function aturTipeFilter($tipe)
    {
        $this->tipeFilter = $tipe;
    }

    public function render()
    {
        // Base Query untuk Barang
        $queryBarang = Barang::query();

        if ($this->tipeFilter == 'medis') {
            $queryBarang->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'like', '%Medis%')
                  ->orWhere('nama_kategori', 'like', '%Kesehatan%')
                  ->orWhere('nama_kategori', 'like', '%Alat%');
            });
        } elseif ($this->tipeFilter == 'umum') {
            $queryBarang->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'not like', '%Medis%')
                  ->where('nama_kategori', 'not like', '%Kesehatan%')
                  ->where('nama_kategori', 'not like', '%Alat%');
            });
        }

        // === METRIK GLOBAL ===
        $totalAset = (clone $queryBarang)->count();
        // Nilai Aset (Estimasi Valuasi)
        $nilaiAsetTotal = (clone $queryBarang)->where('is_asset', true)->sum(DB::raw('harga_perolehan * stok'));
        
        // Statistik Kondisi Aset
        $statistikKondisi = [
            'Baik' => (clone $queryBarang)->where('kondisi', 'Baik')->count(),
            'PerluPerbaikan' => (clone $queryBarang)->where('kondisi', 'Rusak Ringan')->count(),
            'Rusak' => (clone $queryBarang)->where('kondisi', 'Rusak Berat')->count(),
        ];

        // Metrik Spesifik Medis: Kalibrasi Jatuh Tempo
        $kalibrasiJatuhTempo = 0;
        if ($this->tipeFilter == 'medis' || $this->tipeFilter == 'all') {
            $kalibrasiJatuhTempo = Maintenance::whereHas('barang.kategori', function($q) {
                    $q->where('nama_kategori', 'like', '%Medis%');
                })
                ->where('jenis_kegiatan', 'Kalibrasi')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(60)) // Peringatan 2 bulan sebelum
                ->count();
        }

        $dataTab = [];

        // === TAB 1: IKHTISAR ===
        if ($this->tabAktif == 'ikhtisar') {
            $dataTab['distribusiKategori'] = KategoriBarang::withCount(['barangs' => function($q) use ($queryBarang) {
                    // Filter count based on main filter logic
                }])
                ->orderByDesc('barangs_count')
                ->take(6)
                ->get();
            
            $dataTab['aktivitasTerbaru'] = RiwayatBarang::with(['barang', 'user'])
                ->whereHas('barang', function($q) use ($queryBarang) {
                    if ($this->tipeFilter == 'medis') {
                        $q->whereHas('kategori', fn($k) => $k->where('nama_kategori', 'like', '%Medis%'));
                    } elseif ($this->tipeFilter == 'umum') {
                        $q->whereHas('kategori', fn($k) => $k->where('nama_kategori', 'not like', '%Medis%'));
                    }
                })
                ->latest()
                ->take(6)
                ->get();

            $dataTab['lokasiAset'] = Ruangan::withCount('barangs')
                ->orderByDesc('barangs_count')
                ->take(5)
                ->get();
        }

        // === TAB 2: MONITORING STOK ===
        if ($this->tabAktif == 'stok') {
            $dataTab['stokMenipis'] = (clone $queryBarang)->where('is_asset', false) // Bahan Habis Pakai
                ->where('stok', '<=', 10) // Ambang Batas
                ->orderBy('stok')
                ->take(10)
                ->get();
            
            // Grafik Arus Stok 7 Hari
            $dataTab['arusStok'] = $this->dapatkanArusStok();
        }

        // === TAB 3: MAINTENANCE & KALIBRASI ===
        if ($this->tabAktif == 'maintenance') {
            $queryMaintenance = Maintenance::with(['barang.kategori'])
                ->where('status', 'Terjadwal')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(30));

            if ($this->tipeFilter != 'all') {
                $queryMaintenance->whereHas('barang.kategori', function($q) {
                    if ($this->tipeFilter == 'medis') {
                        $q->where('nama_kategori', 'like', '%Medis%');
                    } else {
                        $q->where('nama_kategori', 'not like', '%Medis%');
                    }
                });
            }

            $dataTab['jadwalMaintenance'] = $queryMaintenance->orderBy('tanggal_berikutnya')->get();
            
            // Analisis Biaya
            $dataTab['trenBiaya'] = Maintenance::select(
                    DB::raw("DATE_FORMAT(tanggal_maintenance, '%Y-%m') as bulan"),
                    DB::raw("SUM(biaya) as total_biaya")
                )
                ->where('tanggal_maintenance', '>=', now()->subMonths(6))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $dataTab['rasioMaintenance'] = [
                'preventif' => Maintenance::where('jenis_kegiatan', 'Preventif')->count(),
                'korektif' => Maintenance::where('jenis_kegiatan', 'Perbaikan')->count(),
                'kalibrasi' => Maintenance::where('jenis_kegiatan', 'Kalibrasi')->count(),
            ];
            
            $dataTab['biayaMaintenanceBulanIni'] = Maintenance::whereMonth('tanggal_maintenance', Carbon::now()->month)
                ->whereYear('tanggal_maintenance', Carbon::now()->year)
                ->sum('biaya');
        }

        // === TAB 4: PENGADAAN ===
        if ($this->tabAktif == 'pengadaan') {
            $dataTab['pengadaanPending'] = PengadaanBarang::where('status', 'Pending')->latest()->get();
            $dataTab['totalPengadaanTahunIni'] = PengadaanBarang::join('pengadaan_barang_details', 'pengadaan_barangs.id', '=', 'pengadaan_barang_details.pengadaan_barang_id')
                ->whereYear('pengadaan_barangs.tanggal_pengajuan', Carbon::now()->year)
                ->where('pengadaan_barangs.status', 'Selesai')
                ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));
        }

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAsetTotal',
            'kalibrasiJatuhTempo',
            'statistikKondisi',
            'dataTab'
        ))->layout('layouts.app', ['header' => 'Manajemen Aset & Inventaris']);
    }

    private function dapatkanArusStok()
    {
        $dates = [];
        $masuk = [];
        $keluar = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('d/m');
            
            $masuk[] = RiwayatBarang::whereDate('tanggal', $date)
                ->whereIn('jenis_transaksi', ['Masuk', 'Pengadaan', 'Pembelian'])
                ->sum('jumlah');
                
            $keluar[] = RiwayatBarang::whereDate('tanggal', $date)
                ->whereIn('jenis_transaksi', ['Keluar', 'Mutasi Keluar', 'Pemakaian'])
                ->sum('jumlah');
        }

        return ['labels' => $dates, 'masuk' => $masuk, 'keluar' => $keluar];
    }
}