<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengadaanBarangDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengadaan_barang_id',
        'barang_id',
        'nama_barang_baru',
        'jumlah_minta',
        'jumlah_disetujui',
        'harga_satuan_estimasi',
        'total_harga',
        'spesifikasi'
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}