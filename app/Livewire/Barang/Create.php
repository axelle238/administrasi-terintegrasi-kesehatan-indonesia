<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\DetailAsetMedis;
use App\Models\KategoriBarang;
use App\Models\RiwayatBarang;
use App\Models\Ruangan;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    // General Info
    public $kategori_barang_id;
    public $kode_barang;
    public $nama_barang;
    public $merk;
    public $stok;
    public $satuan;
    public $kondisi = 'Baik';
    public $tanggal_pengadaan;
    public $lokasi_penyimpanan; 
    public $ruangan_id;
    public $supplier_id;
    
    // Asset Financial Details
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
    public $is_medis = false; // State trigger
    public $nomor_izin_edar;
    public $distributor_resmi;
    public $frekuensi_kalibrasi_bulan;
    public $kalibrasi_terakhir;
    public $suhu_penyimpanan;
    public $catatan_teknis;

    protected $rules = [
        'kategori_barang_id' => 'required|exists:kategori_barangs,id',
        'kode_barang' => 'required|string|unique:barangs,kode_barang',
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
        'nomor_seri' => 'nullable|string',
        'harga_perolehan' => 'nullable|numeric|min:0',
        'sumber_dana' => 'nullable|string',
        
        // Validation for Medis (Conditional)
        'nomor_izin_edar' => 'nullable|string',
        'frekuensi_kalibrasi_bulan' => 'nullable|integer|min:1',
    ];

    public function mount()
    {
        $this->tanggal_pengadaan = now()->format('Y-m-d');
        $this->kode_barang = 'BRG-' . strtoupper(uniqid());
    }

    public function updatedKategoriBarangId($value)
    {
        $kategori = KategoriBarang::find($value);
        if ($kategori) {
            $nama = strtolower($kategori->nama_kategori);
            // Auto detect medical category
            $this->is_medis = str_contains($nama, 'medis') || 
                              str_contains($nama, 'kesehatan') || 
                              str_contains($nama, 'obat') ||
                              str_contains($nama, 'alkes');
            
            // Auto set Asset flag logic (optional)
            // $this->is_asset = $this->is_medis; 
        }
    }

    public function updatedHargaPerolehan()
    {
        $this->nilai_buku = $this->harga_perolehan;
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
            
            // Save Detail Medis if applicable
            if ($this->is_medis) {
                DetailAsetMedis::create([
                    'barang_id' => $barang->id,
                    'nomor_izin_edar' => $this->nomor_izin_edar,
                    'distributor_resmi' => $this->distributor_resmi,
                    'frekuensi_kalibrasi_bulan' => $this->frekuensi_kalibrasi_bulan,
                    'kalibrasi_terakhir' => $this->kalibrasi_terakhir,
                    'kalibrasi_selanjutnya' => $this->frekuensi_kalibrasi_bulan && $this->kalibrasi_terakhir 
                        ? \Carbon\Carbon::parse($this->kalibrasi_terakhir)->addMonths($this->frekuensi_kalibrasi_bulan)
                        : null,
                    'suhu_penyimpanan' => $this->suhu_penyimpanan,
                    'catatan_teknis' => $this->catatan_teknis,
                ]);
            }

            // Log Initial Stock
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'user_id' => auth()->id(),
                'jenis_transaksi' => 'Masuk',
                'jumlah' => $this->stok,
                'stok_terakhir' => $this->stok,
                'tanggal' => now(),
                'keterangan' => 'Registrasi Aset Baru'
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
            'kategoris' => KategoriBarang::all(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
            'suppliers' => Supplier::orderBy('nama_supplier')->get(),
        ])->layout('layouts.app', ['header' => 'Registrasi Aset Baru']);
    }
}