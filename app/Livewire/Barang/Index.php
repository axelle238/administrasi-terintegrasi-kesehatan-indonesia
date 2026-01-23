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
    public $isOpen = false;
    public $barangId;

    // Fields
    public $kode_barang;
    public $nama_barang;
    public $kategori_barang_id;
    public $kondisi = 'Baik';
    public $lokasi_penyimpanan;
    public $merk;
    public $spesifikasi;
    public $nomor_seri;
    public $sumber_dana;
    public $harga_perolehan;
    public $masa_manfaat;
    public $is_asset = false;
    public $stok = 0;
    public $satuan = 'Unit';
    public $tanggal_pengadaan;

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

    protected function rules()
    {
        return [
            'kode_barang' => 'required|string|unique:barangs,kode_barang,' . $this->barangId,
            'nama_barang' => 'required|string',
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi_penyimpanan' => 'nullable|string',
            'merk' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'nomor_seri' => 'nullable|string',
            'sumber_dana' => 'nullable|string',
            'harga_perolehan' => 'nullable|numeric|min:0',
            'masa_manfaat' => 'nullable|integer|min:0',
            'is_asset' => 'boolean',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'tanggal_pengadaan' => 'nullable|date',
        ];
    }

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
                $query->where('lokasi_penyimpanan', 'like', '%' . $this->filterLokasi . '%');
            })
            ->when($this->filterLowStock, function ($query) {
                $query->where('stok', '<=', 5);
            });
    }

    public function create()
    {
        $this->barangId = null;
        $this->kode_barang = '';
        $this->nama_barang = '';
        $this->kategori_barang_id = '';
        $this->kondisi = 'Baik';
        $this->lokasi_penyimpanan = '';
        $this->merk = '';
        $this->spesifikasi = '';
        $this->nomor_seri = '';
        $this->sumber_dana = '';
        $this->harga_perolehan = 0;
        $this->masa_manfaat = 0;
        $this->is_asset = false;
        $this->stok = 0;
        $this->satuan = 'Unit';
        $this->tanggal_pengadaan = date('Y-m-d');
        
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barangId = $id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->kategori_barang_id = $barang->kategori_barang_id;
        $this->kondisi = $barang->kondisi;
        $this->lokasi_penyimpanan = $barang->lokasi_penyimpanan;
        $this->merk = $barang->merk;
        $this->spesifikasi = $barang->spesifikasi;
        $this->nomor_seri = $barang->nomor_seri;
        $this->sumber_dana = $barang->sumber_dana;
        $this->harga_perolehan = $barang->harga_perolehan;
        $this->masa_manfaat = $barang->masa_manfaat;
        $this->is_asset = $barang->is_asset;
        $this->stok = $barang->stok;
        $this->satuan = $barang->satuan;
        $this->tanggal_pengadaan = $barang->tanggal_pengadaan ? $barang->tanggal_pengadaan->format('Y-m-d') : null;
        
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'kategori_barang_id' => $this->kategori_barang_id,
            'kondisi' => $this->kondisi,
            'lokasi_penyimpanan' => $this->lokasi_penyimpanan,
            'merk' => $this->merk,
            'spesifikasi' => $this->spesifikasi,
            'nomor_seri' => $this->nomor_seri,
            'sumber_dana' => $this->sumber_dana,
            'harga_perolehan' => $this->harga_perolehan ?: 0,
            'masa_manfaat' => $this->masa_manfaat ?: 0,
            'is_asset' => $this->is_asset,
            'stok' => $this->stok,
            'satuan' => $this->satuan,
            'tanggal_pengadaan' => $this->tanggal_pengadaan,
        ];

        // Calculate Nilai Buku (Initial = Harga Perolehan)
        if (!$this->barangId) {
            $data['nilai_buku'] = $data['harga_perolehan'];
        }

        if ($this->barangId) {
            Barang::find($this->barangId)->update($data);
            $this->dispatch('notify', 'success', 'Aset berhasil diperbarui.');
        } else {
            Barang::create($data);
            $this->dispatch('notify', 'success', 'Aset baru berhasil dicatat.');
        }

        $this->isOpen = false;
    }

    public function render()
    {
        $barangs = $this->getBarangsQuery()
            ->latest()
            ->paginate(10);

        $kategoris = KategoriBarang::all();

        return view('livewire.barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris
        ])->layout('layouts.app', ['header' => 'Inventaris & Aset Puskesmas']);
    }
}