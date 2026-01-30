<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Poli
 * 
 * Mengelola data Poliklinik atau Unit Layanan di Puskesmas.
 * Contoh: Poli Umum, Poli Gigi, Poli KIA.
 */
class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_poli', // Nama Unit/Poli
        'kode_poli', // Kode Unik (misal: P-001)
        'keterangan' // Deskripsi operasional
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
