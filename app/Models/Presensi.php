<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_presensi', // Baru
        'keterangan', // Baru
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'foto_masuk',
        'foto_keluar',
        'lokasi_masuk',
        'lokasi_keluar',
        'status_kehadiran',
        'keterlambatan_menit',
        'catatan_harian',
        'is_late'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
