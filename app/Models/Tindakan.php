<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Tindakan
 * 
 * Master data layanan medis yang tersedia di Puskesmas beserta tarifnya.
 * Contoh: Cabut Gigi, Suntik Vitamin, Konsultasi Umum.
 */
class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tindakan', // Nama layanan
        'poli_id',       // ID Poli terkait
        'harga'          // Tarif layanan (Rupiah)
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}