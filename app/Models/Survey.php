<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'poli_id',
        'nilai', // Nilai Keseluruhan (Rata-rata atau persepsi umum)
        'kritik_saran',
        'ip_address',
        
        // 9 Unsur SKM
        'u1_persyaratan',
        'u2_prosedur',
        'u3_waktu',
        'u4_biaya',
        'u5_produk',
        'u6_kompetensi',
        'u7_perilaku',
        'u8_maklumat',
        'u9_penanganan',

        // Profil Responden
        'umur',
        'jenis_kelamin',
        'pendidikan',
        'pekerjaan',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}