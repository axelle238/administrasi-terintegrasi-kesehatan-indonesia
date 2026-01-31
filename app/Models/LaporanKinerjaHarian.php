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
        'durasi_menit', // New
        'aktivitas',
        'kategori_kegiatan', // New
        'deskripsi',
        'output', // legacy
        'status', // Pending, Disetujui
        'catatan_verifikator',
        'persentase_selesai',
        'kendala_teknis',
        'file_bukti_kerja',
        'tautan_dokumen', // New
        'prioritas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}