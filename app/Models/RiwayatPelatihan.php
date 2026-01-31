<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pelatihan',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_jam',
        'nomor_sertifikat',
        'file_sertifikat',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
