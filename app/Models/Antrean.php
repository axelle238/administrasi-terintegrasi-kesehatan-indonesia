<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Antrean
 * 
 * Mengelola antrean harian pasien untuk berbagai Poli.
 * Digunakan untuk Monitor Antrean dan Dashboard Dokter.
 */
class Antrean extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'poli_id', // Changed from poli_tujuan
        'dokter_id',
        'nomor_antrean',
        'tanggal_antrean',
        'status',
        'no_kunjungan_bpjs',
        'kode_booking',
        'task_id_last'
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relasi: Antrean ditujukan ke satu Poli.
     */
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Relasi: Antrean ditangani oleh satu Dokter.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}