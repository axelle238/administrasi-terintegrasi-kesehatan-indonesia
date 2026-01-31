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
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_jam',
        'nomor_sertifikat',
        'file_sertifikat',
        'status_validasi'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}