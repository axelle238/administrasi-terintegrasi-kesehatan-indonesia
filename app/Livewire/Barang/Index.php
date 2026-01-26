<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Filters
    public $filterKategori = '';
    public $filterKondisi = '';
    public $filterLokasi = '';
    public $filterLowStock = false;

    public $selected = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKategori' => ['except' => ''],
        'filterKondisi' => ['except' => ''],
        'filterLokasi' => ['except' => ''],
        'filterLowStock' => ['except' => false],
    ];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getBarangsQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('notify', 'warning', 'Pilih data terlebih dahulu.');
            return;
        }

        Barang::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('notify', 'success', 'Data terpilih berhasil dihapus.');
    }

    public function printSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('notify', 'warning', 'Pilih data terlebih dahulu.');
            return;
        }

        return redirect()->route('barang.print-labels-bulk', ['ids' => implode(',', $this->selected)]);
    }

    public function exportCsv()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=aset_inventaris_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Kode', 'Nama Barang', 'Merk', 'Kategori', 'Stok', 'Satuan', 'Kondisi', 'Lokasi', 'Tanggal Pengadaan', 'Nilai Buku'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $query = $this->getBarangsQuery();
            
            $query->chunk(100, function($barangs) use ($file) {
                foreach ($barangs as $barang) {
                    fputcsv($file, [
                        $barang->kode_barang,
                        $barang->nama_barang,
                        $barang->merk,
                        $barang->kategori->nama_kategori ?? '-',
                        $barang->stok,
                        $barang->satuan,
                        $barang->kondisi,
                        $barang->ruangan->nama_ruangan ?? ($barang->lokasi_penyimpanan ?? '-'),
                        $barang->tanggal_pengadaan ? $barang->tanggal_pengadaan->format('Y-m-d') : '-',
                        $barang->nilai_buku
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getBarangsQuery()
    {
        return Barang::with(['kategori', 'ruangan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_barang', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                      ->orWhere('merk', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKategori, function ($query) {
                $query->where('kategori_barang_id', $this->filterKategori);
            })
            ->when($this->filterKondisi, function ($query) {
                $query->where('kondisi', $this->filterKondisi);
            })
            ->when($this->filterLokasi, function ($query) {
                $query->where('lokasi_penyimpanan', 'like', '%' . $this->filterLokasi . '%')
                      ->orWhereHas('ruangan', function($q) {
                          $q->where('nama_ruangan', 'like', '%' . $this->filterLokasi . '%');
                      });
            })
            ->when($this->filterLowStock, function ($query) {
                $query->where('stok', '<=', 5);
            });
    }

    public function render()
    {
        $barangs = $this->getBarangsQuery()
            ->latest()
            ->paginate(10);

        $kategoris = KategoriBarang::all();

        // Dashboard Ringkas Stats
        $totalAset = Barang::count();
        $nilaiAset = Barang::sum('nilai_buku');
        $asetRusak = Barang::where('kondisi', '!=', 'Baik')->count();
        $stokMenipis = Barang::where('stok', '<=', 5)->count();

        return view('livewire.barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'totalAset' => $totalAset,
            'nilaiAset' => $nilaiAset,
            'asetRusak' => $asetRusak,
            'stokMenipis' => $stokMenipis,
        ])->layout('layouts.app', ['header' => 'Inventaris & Aset Puskesmas']);
    }
}