<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Ruangan;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Barang $barang;
    
    public $kategori_barang_id;
    public $kode_barang;
    public $nama_barang;
    public $merk;
    public $stok; // Stok is usually not edited directly here, but let's allow correction
    public $satuan;
    public $kondisi;
    public $tanggal_pengadaan;
    public $lokasi_penyimpanan;
    public $ruangan_id;
    public $supplier_id;
    
    // Asset Details
    public $is_asset = false;
    public $spesifikasi;
    public $nomor_seri;
    public $nomor_pabrik;
    public $nomor_registrasi;
    public $sumber_dana;
    public $harga_perolehan = 0;
    public $nilai_buku = 0;
    public $masa_manfaat = 0;
    public $nilai_residu = 0;
    public $keterangan;

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->kategori_barang_id = $barang->kategori_barang_id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->merk = $barang->merk;
        $this->stok = $barang->stok;
        $this->satuan = $barang->satuan;
        $this->kondisi = $barang->kondisi;
        $this->tanggal_pengadaan = $barang->tanggal_pengadaan;
        $this->lokasi_penyimpanan = $barang->lokasi_penyimpanan;
        $this->ruangan_id = $barang->ruangan_id;
        $this->supplier_id = $barang->supplier_id;
        
        $this->is_asset = $barang->is_asset;
        $this->spesifikasi = $barang->spesifikasi;
        $this->nomor_seri = $barang->nomor_seri;
        $this->nomor_pabrik = $barang->nomor_pabrik;
        $this->nomor_registrasi = $barang->nomor_registrasi;
        $this->sumber_dana = $barang->sumber_dana;
        $this->harga_perolehan = $barang->harga_perolehan;
        $this->nilai_buku = $barang->nilai_buku;
        $this->masa_manfaat = $barang->masa_manfaat;
        $this->nilai_residu = $barang->nilai_residu;
        $this->keterangan = $barang->keterangan;
    }

    public function update()
    {
        $this->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'kode_barang' => ['required', 'string', Rule::unique('barangs')->ignore($this->barang->id)],
            'nama_barang' => 'required|string|max:255',
            'merk' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'required|date',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_asset' => 'boolean',
            'spesifikasi' => 'nullable|string',
        ]);

        $this->barang->update([
            'kategori_barang_id' => $this->kategori_barang_id,
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'merk' => $this->merk,
            'stok' => $this->stok,
            'satuan' => $this->satuan,
            'kondisi' => $this->kondisi,
            'tanggal_pengadaan' => $this->tanggal_pengadaan,
            // 'lokasi_penyimpanan' => $this->lokasi_penyimpanan, // Prefer sync with room name if needed, or just rely on ID
            'ruangan_id' => $this->ruangan_id,
            'supplier_id' => $this->supplier_id,
            'is_asset' => $this->is_asset,
            'spesifikasi' => $this->spesifikasi,
            'nomor_seri' => $this->nomor_seri,
            'nomor_pabrik' => $this->nomor_pabrik,
            'nomor_registrasi' => $this->nomor_registrasi,
            'sumber_dana' => $this->sumber_dana,
            'harga_perolehan' => $this->harga_perolehan ?: 0,
            'nilai_buku' => $this->nilai_buku ?: 0,
            'masa_manfaat' => $this->masa_manfaat ?: 0,
            'nilai_residu' => $this->nilai_residu ?: 0,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Data barang berhasil diperbarui.');
        return $this->redirect(route('barang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.edit', [
            'kategoris' => KategoriBarang::all(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
            'suppliers' => Supplier::orderBy('nama_supplier')->get(),
        ])->layout('layouts.app', ['header' => 'Edit Data Barang']);
    }
}