<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Laporan extends Component
{
    use WithPagination;

    public $jenis_laporan = 'stok'; // stok, mutasi, aset
    public $jenis_aset = 'all'; // all, medis, umum
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $kategori_filter = '';

    public function mount()
    {
        $this->tanggal_mulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = now()->endOfMonth()->format('Y-m-d');
    }

    protected function applyAssetFilter($query)
    {
        if ($this->jenis_aset == 'medis') {
            $query->where(function($q) {
                $q->where('jenis_aset', 'Medis')
                  ->orWhereHas('kategori', function($sq) {
                      $sq->where('nama_kategori', 'like', '%Medis%')
                        ->orWhere('nama_kategori', 'like', '%Kesehatan%')
                        ->orWhere('nama_kategori', 'like', '%Alat%');
                  });
            });
        } elseif ($this->jenis_aset == 'umum') {
            $query->where(function($q) {
                $q->where('jenis_aset', '!=', 'Medis')
                  ->orWhere(function($subQ) {
                      $subQ->whereNull('jenis_aset')
                           ->whereHas('kategori', function($sq) {
                               $sq->where('nama_kategori', 'not like', '%Medis%')
                                  ->where('nama_kategori', 'not like', '%Kesehatan%')
                                  ->where('nama_kategori', 'not like', '%Alat%');
                           });
                  });
            });
        }
        return $query;
    }

    public function exportCsv()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan_" . $this->jenis_laporan . "_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            if ($this->jenis_laporan == 'stok') {
                fputcsv($file, ['Kode', 'Nama Barang', 'Jenis', 'Kategori', 'Lokasi', 'Stok', 'Satuan', 'Kondisi']);
                
                $query = Barang::query();
                $this->applyAssetFilter($query);
                
                if ($this->kategori_filter) {
                    $query->where('kategori_barang_id', $this->kategori_filter);
                }
                
                $query->chunk(100, function($items) use ($file) {
                    foreach ($items as $item) {
                        fputcsv($file, [
                            $item->kode_barang,
                            $item->nama_barang,
                            $item->jenis_aset ?? 'Umum',
                            $item->kategori->nama_kategori ?? '-',
                            $item->ruangan->nama_ruangan ?? ($item->lokasi_penyimpanan ?? '-'),
                            $item->stok,
                            $item->satuan,
                            $item->kondisi
                        ]);
                    }
                });
            } 
            elseif ($this->jenis_laporan == 'mutasi') {
                fputcsv($file, ['Tanggal', 'Barang', 'Jenis Transaksi', 'Jumlah', 'Stok Akhir', 'Keterangan', 'PJ']);

                $query = RiwayatBarang::with(['barang', 'user'])
                    ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai]);
                
                // Apply asset filter on relationship
                if ($this->jenis_aset != 'all') {
                    $query->whereHas('barang', function($q) {
                        $this->applyAssetFilter($q);
                    });
                }

                if ($this->kategori_filter) {
                    $query->whereHas('barang', function($q) {
                        $q->where('kategori_barang_id', $this->kategori_filter);
                    });
                }

                $query->chunk(100, function($items) use ($file) {
                    foreach ($items as $item) {
                        fputcsv($file, [
                            $item->tanggal,
                            $item->barang->nama_barang,
                            $item->jenis_transaksi,
                            $item->jumlah,
                            $item->stok_terakhir,
                            $item->keterangan,
                            $item->user->name ?? '-'
                        ]);
                    }
                });
            }
            elseif ($this->jenis_laporan == 'aset') {
                $columns = ['Kode Aset', 'Nama Aset', 'Jenis', 'Kategori', 'Tgl Perolehan', 'Harga Perolehan', 'Nilai Buku', 'Kondisi', 'Lokasi'];
                
                // Add medical columns if needed
                if ($this->jenis_aset == 'medis' || $this->jenis_aset == 'all') {
                    $columns[] = 'No Izin Edar';
                    $columns[] = 'Next Kalibrasi';
                }

                fputcsv($file, $columns);

                $query = Barang::with('detailMedis')->where('is_asset', true);
                $this->applyAssetFilter($query);

                if ($this->kategori_filter) {
                    $query->where('kategori_barang_id', $this->kategori_filter);
                }

                $query->chunk(100, function($items) use ($file) {
                    foreach ($items as $item) {
                        $row = [
                            $item->kode_barang,
                            $item->nama_barang,
                            $item->jenis_aset ?? 'Umum',
                            $item->kategori->nama_kategori ?? '-',
                            $item->tanggal_pengadaan,
                            $item->harga_perolehan,
                            $item->nilai_buku,
                            $item->kondisi,
                            $item->ruangan->nama_ruangan ?? ($item->lokasi_penyimpanan ?? '-')
                        ];

                        if ($this->jenis_aset == 'medis' || $this->jenis_aset == 'all') {
                            $row[] = $item->detailMedis->nomor_izin_edar ?? '-';
                            $row[] = $item->detailMedis->kalibrasi_selanjutnya ?? '-';
                        }

                        fputcsv($file, $row);
                    }
                });
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $data = [];

        if ($this->jenis_laporan == 'stok') {
            $query = Barang::query();
            $this->applyAssetFilter($query);
            
            if ($this->kategori_filter) {
                $query->where('kategori_barang_id', $this->kategori_filter);
            }
            $data = $query->orderBy('nama_barang')->paginate(20);
        } 
        elseif ($this->jenis_laporan == 'mutasi') {
            $query = RiwayatBarang::with(['barang', 'user'])
                ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai]);
            
            if ($this->jenis_aset != 'all') {
                $query->whereHas('barang', function($q) {
                    $this->applyAssetFilter($q);
                });
            }

            if ($this->kategori_filter) {
                $query->whereHas('barang', function($q) {
                    $q->where('kategori_barang_id', $this->kategori_filter);
                });
            }
            $data = $query->latest()->paginate(20);
        }
        elseif ($this->jenis_laporan == 'aset') {
            $query = Barang::with('detailMedis')->where('is_asset', true);
            $this->applyAssetFilter($query);
            
            if ($this->kategori_filter) {
                $query->where('kategori_barang_id', $this->kategori_filter);
            }
            $data = $query->orderBy('nama_barang')->paginate(20);
        }

        return view('livewire.barang.laporan', [
            'data' => $data,
            'kategoris' => \App\Models\KategoriBarang::all()
        ])->layout('layouts.app', ['header' => 'Laporan Inventaris']);
    }
}