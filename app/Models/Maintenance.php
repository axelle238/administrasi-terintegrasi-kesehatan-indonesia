<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'tanggal_maintenance',
        'jenis_kegiatan',
        'keterangan',
        'teknisi',
        'biaya',
        'file_sertifikat',
        'tanggal_berikutnya',
        'status'
    ];

    protected $casts = [
        'tanggal_maintenance' => 'date',
        'tanggal_berikutnya' => 'date',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}