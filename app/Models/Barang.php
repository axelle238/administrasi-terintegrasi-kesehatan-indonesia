<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\HasDepreciation;

class Barang extends Model
{
    use HasFactory, LogsActivity, HasDepreciation, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected $fillable = [
        'kategori_barang_id',
        'kode_barang',
        'nama_barang',
        'gambar',
        'merk',
        'stok',
        'min_stok',
        'satuan',
        'kondisi',
        'status_ketersediaan',
        'lokasi_penyimpanan',
        'tanggal_pengadaan',
        'spesifikasi',
        'nomor_seri',
        'nomor_pabrik',
        'nomor_registrasi',
        'sumber_dana',
        'harga_perolehan',
        'nilai_buku',
        'masa_manfaat',
        'nilai_residu',
        'keterangan',
        'is_asset',
        'jenis_aset',
        'nomor_inventaris',
        'nomor_izin_edar',
        'tanggal_kalibrasi_terakhir',
        'tanggal_kalibrasi_berikutnya',
        'distributor',
        'metode_penyusutan',
        'spesifikasi_teknis',
        'ruangan_id',
        'supplier_id',
        'garansi_mulai',
        'garansi_selesai',
        'penanggung_garansi',
        'cakupan_garansi',
        'nomor_kontrak_servis',
    ];

    protected $casts = [
        'is_asset' => 'boolean',
        'harga_perolehan' => 'decimal:2',
        'nilai_buku' => 'decimal:2',
        'nilai_residu' => 'decimal:2',
        'tanggal_pengadaan' => 'date',
        'tanggal_kalibrasi_terakhir' => 'date',
        'tanggal_kalibrasi_berikutnya' => 'date',
        'garansi_mulai' => 'date',
        'garansi_selesai' => 'date',
    ];

    public function scopeAsset($query)
    {
        return $query->where('is_asset', true);
    }

    public function scopeConsumable($query)
    {
        return $query->where('is_asset', false);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailMedis()
    {
        return $this->hasOne(DetailAsetMedis::class);
    }

    public function depresiasi()
    {
        return $this->hasMany(DepresiasiAset::class);
    }

    public function images()
    {
        return $this->hasMany(BarangImage::class);
    }
}
