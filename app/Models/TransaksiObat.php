<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'jenis_transaksi',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
        'pencatat',
    ];

    /**
     * Relasi: Transaksi milik satu Obat
     */
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}