<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'shift_jam_masuk' => 'datetime',
        'shift_jam_keluar' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk status kehadiran
    public function getStatusKehadiranAttribute()
    {
        if (!$this->jam_masuk) return 'Tidak Hadir';
        if ($this->jam_keluar) return 'Hadir (Lengkap)';
        return 'Sedang Bekerja';
    }
}