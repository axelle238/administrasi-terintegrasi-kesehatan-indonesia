<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'lokasi_asal',
        'lokasi_tujuan',
        'jumlah',
        'tanggal_mutasi',
        'penanggung_jawab',
        'keterangan'
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}