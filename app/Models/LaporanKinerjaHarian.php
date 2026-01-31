<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKinerjaHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'aktivitas',
        'deskripsi',
        'output', // legacy
        'status', // Pending, Disetujui
        'catatan_verifikator',
        
        // New Fields
        'persentase_selesai',
        'kendala_teknis',
        'file_bukti_kerja',
        'prioritas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
