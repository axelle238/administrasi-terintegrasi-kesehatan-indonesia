<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepresiasiAset extends Model
{
    protected $table = 'depresiasi_aset';
    
    protected $fillable = [
        'barang_id',
        'tahun_ke',
        'nilai_buku_awal',
        'nilai_penyusutan',
        'nilai_buku_akhir',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}