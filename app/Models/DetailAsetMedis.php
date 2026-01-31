<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAsetMedis extends Model
{
    protected $table = 'detail_aset_medis';
    
    protected $fillable = [
        'barang_id',
        'nomor_izin_edar',
        'distributor_resmi',
        'frekuensi_kalibrasi_bulan',
        'kalibrasi_terakhir',
        'kalibrasi_selanjutnya',
        'suhu_penyimpanan',
        'wajib_maintenance',
        'catatan_teknis',
    ];

    protected $casts = [
        'kalibrasi_terakhir' => 'date',
        'kalibrasi_selanjutnya' => 'date',
        'wajib_maintenance' => 'boolean',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}