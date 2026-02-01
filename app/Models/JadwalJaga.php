<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalJaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'shift_id',
        'tanggal',
        'status_kehadiran',
        'kuota_online',
        'kuota_offline',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
    
    // Helper untuk mengambil poli dari pegawai
    public function getPoliAttribute()
    {
        return $this->pegawai->poli ?? null;
    }
}