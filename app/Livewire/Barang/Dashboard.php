<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Maintenance;
use App\Models\PengadaanBarang;
use App\Models\RiwayatBarang;
use App\Models\Ruangan;
use App\Models\PeminjamanBarang;
use App\Models\MutasiBarang;
use App\Models\PenghapusanBarang;
use App\Models\Opname;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    #[Url(keep: true)]
    public $tabAktif = 'ikhtisar'; // ikhtisar, stok, maintenance, pengadaan, peminjaman, audit

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

        // === METRIK GLOBAL (Top Cards) ===
        $totalAset = (clone $queryBarang)->count();
        $nilaiAsetTotal = (clone $queryBarang)->where('is_asset', true)->sum(DB::raw('harga_perolehan * stok'));
        
        $statistikKondisi = [
            'Baik' => (clone $queryBarang)->where('kondisi', 'Baik')->count(),
            'PerluPerbaikan' => (clone $queryBarang)->where('kondisi', 'Rusak Ringan')->count(),
            'Rusak' => (clone $queryBarang)->where('kondisi', 'Rusak Berat')->count(),
        ];

        // Alert Global
        $kalibrasiJatuhTempo = 0;
        if ($this->tipeFilter == 'medis' || $this->tipeFilter == 'all') {
            $kalibrasiJatuhTempo = Maintenance::whereHas('barang.kategori', function($q) {
                    $q->where('nama_kategori', 'like', '%Medis%');
                })
                ->where('jenis_kegiatan', 'Kalibrasi')
                ->whereDate('tanggal_berikutnya', '<=', now()->addDays(60))
                ->count();
        }

        $peminjamanAktif = PeminjamanBarang::where('status', 'Dipinjam')->count();
        $disposalPending = PenghapusanBarang::where('status', 'Pending')->count();
        
        $garansiExpiring = 0;
        if ($this->tipeFilter != 'umum') {
            $garansiExpiring = Barang::whereNotNull('garansi_selesai')
                ->whereBetween('garansi_selesai', [now(), now()->addDays(30)])
                ->count();
        }

        $dataTab = [];

        // === TAB 1: IKHTISAR ===
        if ($this->tabAktif == 'ikhtisar') {
            $dataTab['distribusiKategori'] = KategoriBarang::withCount(['barangs'])
                ->orderByDesc('barangs_count')
                ->take(6)
                ->get();
            
            // Analisis Depresiasi per Kategori (NEW)
            $dataTab['depresiasiKategori'] = KategoriBarang::join('barangs', 'kategori_barangs.id', '=', 'barangs.kategori_id')
                ->where('barangs.is_asset', true)
                ->select('kategori_barangs.nama_kategori', DB::raw('SUM(barangs.harga_perolehan - barangs.nilai_residu) as total_depresiasi'))
                ->groupBy('kategori_barangs.nama_kategori')
                ->get();

            $dataTab['aktivitasTerbaru'] = RiwayatBarang::with(['barang', 'user'])
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
            $dataTab['stokMenipis'] = (clone $queryBarang)->where('is_asset', false)
                ->where('stok', '<=', 10)
                ->orderBy('stok')
                ->take(10)
                ->get();
            
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
            
            $dataTab['rasioMaintenance'] = [
                'preventif' => Maintenance::where('jenis_kegiatan', 'Preventif')->count(),
                'korektif' => Maintenance::where('jenis_kegiatan', 'Perbaikan')->count(),
                'kalibrasi' => Maintenance::where('jenis_kegiatan', 'Kalibrasi')->count(),
            ];
            
            $dataTab['biayaMaintenanceBulanIni'] = Maintenance::whereMonth('tanggal_maintenance', Carbon::now()->month)
                ->whereYear('tanggal_maintenance', Carbon::now()->year)
                ->sum('biaya');
        }

        // === TAB 4: PENGADAAN & PENGHAPUSAN ===
        if ($this->tabAktif == 'pengadaan') {
            $dataTab['pengadaanPending'] = PengadaanBarang::where('status', 'Pending')->latest()->get();
            $dataTab['penghapusanPending'] = PenghapusanBarang::where('status', 'Pending')->with('pemohon')->latest()->get();
            
            $dataTab['totalPengadaanTahunIni'] = PengadaanBarang::join('pengadaan_barang_details', 'pengadaan_barangs.id', '=', 'pengadaan_barang_details.pengadaan_barang_id')
                ->whereYear('pengadaan_barangs.tanggal_pengajuan', Carbon::now()->year)
                ->where('pengadaan_barangs.status', 'Selesai')
                ->sum(DB::raw('pengadaan_barang_details.jumlah_permintaan * pengadaan_barang_details.estimasi_harga_satuan'));
        }

        // === TAB 5: PEMINJAMAN & MUTASI (OPERASIONAL) ===
        if ($this->tabAktif == 'peminjaman') {
            $dataTab['peminjamanAktif'] = PeminjamanBarang::with(['barang', 'pegawai.user'])
                ->where('status', 'Dipinjam')
                ->orderBy('tanggal_kembali_rencana', 'asc') // Yang deadline duluan diatas
                ->get();

            $dataTab['mutasiTerbaru'] = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
                ->latest('tanggal_mutasi')
                ->take(10)
                ->get();
        }

        // === TAB 6: AUDIT (OPNAME) ===
        if ($this->tabAktif == 'audit') {
            $dataTab['opnameTerakhir'] = Opname::with(['user', 'ruangan'])
                ->latest('tanggal')
                ->take(5)
                ->get();
            
            // Hitung akurasi stok (barang dengan selisih 0 di detail opname terakhir)
            $lastOpname = Opname::latest()->first();
            $dataTab['akurasiStok'] = 100;
            if($lastOpname) {
                $totalItems = $lastOpname->details()->count();
                $matchItems = $lastOpname->details()->where('selisih', 0)->count();
                $dataTab['akurasiStok'] = $totalItems > 0 ? ($matchItems / $totalItems) * 100 : 100;
            }
        }

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAsetTotal',
            'kalibrasiJatuhTempo',
            'statistikKondisi',
            'peminjamanAktif',
            'disposalPending',
            'garansiExpiring',
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
