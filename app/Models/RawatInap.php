<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawatInap extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'kamar_id',
        'waktu_masuk',
        'waktu_keluar',
        'diagnosa_awal',
        'diagnosa_akhir',
        'status',
        'jenis_pembayaran'
    ];

    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }
}
