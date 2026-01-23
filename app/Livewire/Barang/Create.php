<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\RiwayatBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $kategori_barang_id;
    public $kode_barang;
    public $nama_barang;
    public $merk;
    public $stok;
    public $satuan;
    public $kondisi = 'Baik';
    public $tanggal_pengadaan;
    public $lokasi_penyimpanan;

    protected $rules = [
        'kategori_barang_id' => 'required|exists:kategori_barangs,id',
        'kode_barang' => 'required|string|unique:barangs,kode_barang',
        'nama_barang' => 'required|string|max:255',
        'merk' => 'nullable|string',
        'stok' => 'required|integer|min:0',
        'satuan' => 'required|string',
        'kondisi' => 'required|string',
        'tanggal_pengadaan' => 'required|date',
        'lokasi_penyimpanan' => 'nullable|string',
    ];

    public function mount()
    {
        $this->tanggal_pengadaan = now()->format('Y-m-d');
        // Generate Auto Code Suggestion (Optional)
        $this->kode_barang = 'BRG-' . strtoupper(uniqid());
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            $barang = Barang::create([
                'kategori_barang_id' => $this->kategori_barang_id,
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'merk' => $this->merk,
                'stok' => $this->stok,
                'satuan' => $this->satuan,
                'kondisi' => $this->kondisi,
                'tanggal_pengadaan' => $this->tanggal_pengadaan,
                'lokasi_penyimpanan' => $this->lokasi_penyimpanan,
            ]);
            
            // Log Initial Stock
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'user_id' => auth()->id(),
                'jenis_transaksi' => 'Masuk',
                'jumlah' => $this->stok,
                'stok_terakhir' => $this->stok,
                'tanggal' => now(),
                'keterangan' => 'Stok Awal'
            ]);
            
            DB::commit();
            $this->dispatch('notify', 'success', 'Data barang berhasil ditambahkan.');
            return $this->redirect(route('barang.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal menambah barang: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.barang.create', [
            'kategoris' => KategoriBarang::all()
        ])->layout('layouts.app', ['header' => 'Tambah Barang Baru']);
    }
}