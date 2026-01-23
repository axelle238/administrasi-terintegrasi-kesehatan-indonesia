<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanBarangDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penghapusan_barang_id',
        'barang_id',
        'jumlah',
        'kondisi_terakhir',
        'nilai_buku_saat_ini',
        'estimasi_nilai_jual',
        'alasan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}