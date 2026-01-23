<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeterangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'pasien_id',
        'dokter_id',
        'jenis_surat',
        'tanggal_surat',
        'data_medis',
        'keperluan',
        'lama_istirahat',
        'mulai_istirahat',
        'catatan'
    ];

    protected $casts = [
        'data_medis' => 'array',
        'tanggal_surat' => 'date',
        'mulai_istirahat' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}