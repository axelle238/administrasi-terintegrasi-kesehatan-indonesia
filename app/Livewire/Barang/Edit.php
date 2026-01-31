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

    // Detail Medis (Specific)
    public $is_medis = false;
    public $nomor_izin_edar;
    public $distributor_resmi;
    public $frekuensi_kalibrasi_bulan;
    public $kalibrasi_terakhir;
    public $suhu_penyimpanan;
    public $catatan_teknis;

    public function mount(Barang $barang)
    {
        $this->barang = $barang->load('detailMedis', 'kategori');
        
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

        // Load Medical Details
        $this->detectMedisState();
        if ($barang->detailMedis) {
            $this->nomor_izin_edar = $barang->detailMedis->nomor_izin_edar;
            $this->distributor_resmi = $barang->detailMedis->distributor_resmi;
            $this->frekuensi_kalibrasi_bulan = $barang->detailMedis->frekuensi_kalibrasi_bulan;
            $this->kalibrasi_terakhir = $barang->detailMedis->kalibrasi_terakhir;
            $this->suhu_penyimpanan = $barang->detailMedis->suhu_penyimpanan;
            $this->catatan_teknis = $barang->detailMedis->catatan_teknis;
        }
    }

    public function updatedKategoriBarangId($value)
    {
        $this->detectMedisState();
    }

    protected function detectMedisState()
    {
        if ($this->kategori_barang_id) {
            $kategori = KategoriBarang::find($this->kategori_barang_id);
            if ($kategori) {
                $nama = strtolower($kategori->nama_kategori);
                $this->is_medis = str_contains($nama, 'medis') || 
                                  str_contains($nama, 'kesehatan') || 
                                  str_contains($nama, 'obat') ||
                                  str_contains($nama, 'alkes');
            }
        }
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
            'nomor_izin_edar' => 'nullable|string',
            'frekuensi_kalibrasi_bulan' => 'nullable|integer|min:1',
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

        // Update or Create Detail Medis
        if ($this->is_medis) {
            $this->barang->detailMedis()->updateOrCreate(
                ['barang_id' => $this->barang->id],
                [
                    'nomor_izin_edar' => $this->nomor_izin_edar,
                    'distributor_resmi' => $this->distributor_resmi,
                    'frekuensi_kalibrasi_bulan' => $this->frekuensi_kalibrasi_bulan,
                    'kalibrasi_terakhir' => $this->kalibrasi_terakhir,
                    'kalibrasi_selanjutnya' => $this->frekuensi_kalibrasi_bulan && $this->kalibrasi_terakhir 
                        ? \Carbon\Carbon::parse($this->kalibrasi_terakhir)->addMonths($this->frekuensi_kalibrasi_bulan)
                        : null,
                    'suhu_penyimpanan' => $this->suhu_penyimpanan,
                    'catatan_teknis' => $this->catatan_teknis,
                ]
            );
        } else {
            // Optional: Delete detail medis if category changed to non-medis
            $this->barang->detailMedis()->delete();
        }

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