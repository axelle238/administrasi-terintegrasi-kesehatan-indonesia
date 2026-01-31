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
        'output',
        'file_bukti',
        'status',
        'catatan_verifikator'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}