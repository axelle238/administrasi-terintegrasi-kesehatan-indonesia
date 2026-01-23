<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Surat
 * 
 * Mengelola arsip surat menyurat digital (Masuk & Keluar).
 * Mendukung upload file lampiran dan tracking disposisi.
 */
class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',      // Nomor resmi surat
        'tanggal_surat',    // Tanggal yang tertera di surat
        'tanggal_diterima', // Tanggal surat diterima (khusus surat masuk)
        'pengirim',         // Asal surat
        'penerima',         // Tujuan surat
        'perihal',          // Isi ringkas surat
        'jenis_surat',      // Masuk / Keluar
        'file_path',        // Lokasi file upload (PDF/Image)
        
        // Legacy Columns (Dipertahankan untuk kompatibilitas data lama jika ada)
        'disposisi',        
        'tujuan_disposisi', 
        'status_disposisi', 
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    /**
     * Relasi: Satu surat bisa memiliki banyak riwayat disposisi.
     */
    public function disposisiSurats(): HasMany
    {
        return $this->hasMany(DisposisiSurat::class);
    }
}