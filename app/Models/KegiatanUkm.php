<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanUkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan', 'tanggal_kegiatan', 'lokasi', 'penanggung_jawab', 'jumlah_peserta', 'hasil_kegiatan'
    ];
}