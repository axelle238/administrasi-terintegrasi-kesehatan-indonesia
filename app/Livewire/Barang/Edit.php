<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\BarangImage;
use App\Models\KategoriBarang;
use App\Models\Ruangan;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Edit extends Component
{
    use WithFileUploads;

    public Barang $barang;
    
    // Core Data
    public $kategori_barang_id;
    public $kode_barang;
    public $nama_barang;
    public $merk;
    public $stok;
    public $min_stok;
    public $satuan;
    public $kondisi;
    public $status_ketersediaan;
    public $tanggal_pengadaan;
    public $lokasi_penyimpanan;
    public $ruangan_id;
    public $supplier_id;
    
    // Asset Financials
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

    // Warranty
    public $garansi_mulai;
    public $garansi_selesai;
    public $penanggung_garansi;
    public $cakupan_garansi;
    public $nomor_kontrak_servis;

    // Detail Medis (Specific)
    public $is_medis = false;
    public $nomor_izin_edar;
    public $distributor_resmi;
    public $frekuensi_kalibrasi_bulan;
    public $kalibrasi_terakhir;
    public $suhu_penyimpanan;
    public $catatan_teknis;

    // Gallery
    public $existingPhotos = [];
    public $newPhotos = [];

    public function mount(Barang $barang)
    {
        $this->barang = $barang->load('detailMedis', 'kategori', 'images');
        
        // Hydrate Core
        $this->fill($barang->only([
            'kategori_barang_id', 'kode_barang', 'nama_barang', 'merk', 'stok', 'min_stok',
            'satuan', 'kondisi', 'status_ketersediaan', 'tanggal_pengadaan', 'lokasi_penyimpanan',
            'ruangan_id', 'supplier_id', 'is_asset', 'spesifikasi', 'nomor_seri', 'nomor_pabrik',
            'nomor_registrasi', 'sumber_dana', 'harga_perolehan', 'nilai_buku', 'masa_manfaat',
            'nilai_residu', 'keterangan',
            'garansi_mulai', 'garansi_selesai', 'penanggung_garansi', 'cakupan_garansi', 'nomor_kontrak_servis'
        ]));

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

        // Hydrate Images
        $this->existingPhotos = $barang->images;
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

    public function deleteImage($imageId)
    {
        $image = BarangImage::find($imageId);
        if ($image && $image->barang_id == $this->barang->id) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
            $this->existingPhotos = $this->barang->refresh()->images;
            $this->dispatch('notify', 'success', 'Foto berhasil dihapus.');
        }
    }

    public function setPrimaryImage($imageId)
    {
        $image = BarangImage::find($imageId);
        if ($image && $image->barang_id == $this->barang->id) {
            // Reset others
            BarangImage::where('barang_id', $this->barang->id)->update(['is_primary' => false]);
            
            // Set new primary
            $image->update(['is_primary' => true]);
            
            // Update main barang table thumbnail for performance
            $this->barang->update(['gambar' => $image->image_path]);
            
            $this->existingPhotos = $this->barang->refresh()->images;
            $this->dispatch('notify', 'success', 'Foto utama diperbarui.');
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
            'min_stok' => 'nullable|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|string',
            'status_ketersediaan' => 'required|string',
            'tanggal_pengadaan' => 'required|date',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_asset' => 'boolean',
            'spesifikasi' => 'nullable|string',
            'nomor_seri' => 'nullable|string',
            'harga_perolehan' => 'nullable|numeric|min:0',
            'sumber_dana' => 'nullable|string',
            'garansi_mulai' => 'nullable|date',
            'garansi_selesai' => 'nullable|date|after_or_equal:garansi_mulai',
            'nomor_izin_edar' => 'nullable|string',
            'frekuensi_kalibrasi_bulan' => 'nullable|integer|min:1',
            'newPhotos.*' => 'image|max:2048', // 2MB Max
        ]);

        DB::beginTransaction();
        try {
            $this->barang->update([
                'kategori_barang_id' => $this->kategori_barang_id,
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'merk' => $this->merk,
                'stok' => $this->stok,
                'min_stok' => $this->min_stok ?? 0,
                'satuan' => $this->satuan,
                'kondisi' => $this->kondisi,
                'status_ketersediaan' => $this->status_ketersediaan,
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
                'garansi_mulai' => $this->garansi_mulai,
                'garansi_selesai' => $this->garansi_selesai,
                'penanggung_garansi' => $this->penanggung_garansi,
                'cakupan_garansi' => $this->cakupan_garansi,
                'nomor_kontrak_servis' => $this->nomor_kontrak_servis,
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
                        'kalibrasi_selanjutnya' => ($this->frekuensi_kalibrasi_bulan && $this->kalibrasi_terakhir)
                            ? Carbon::parse($this->kalibrasi_terakhir)->addMonths($this->frekuensi_kalibrasi_bulan)
                            : null,
                        'suhu_penyimpanan' => $this->suhu_penyimpanan,
                        'catatan_teknis' => $this->catatan_teknis,
                    ]
                );
            } else {
                if ($this->barang->detailMedis) {
                    $this->barang->detailMedis()->delete();
                }
            }

            // Handle New Photos
            foreach ($this->newPhotos as $photo) {
                $path = $photo->store('barang-images', 'public');
                
                // If no existing photos, make this primary
                $isPrimary = $this->barang->images()->count() == 0;

                BarangImage::create([
                    'barang_id' => $this->barang->id,
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                    'kategori' => 'Galeri Update'
                ]);

                if ($isPrimary) {
                    $this->barang->update(['gambar' => $path]);
                }
            }

            DB::commit();
            $this->dispatch('notify', 'success', 'Data aset berhasil diperbarui.');
            return $this->redirect(route('barang.show', $this->barang->id), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.barang.edit', [
            'kategoris' => KategoriBarang::all(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
            'suppliers' => Supplier::orderBy('nama_supplier')->get(),
        ])->layout('layouts.app', ['header' => 'Edit Aset: ' . $this->barang->nama_barang]);
    }
}