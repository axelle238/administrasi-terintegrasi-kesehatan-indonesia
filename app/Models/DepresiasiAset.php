<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepresiasiAset extends Model
{
    protected $table = 'depresiasi_aset';
    
    protected $table = 'depresiasi_logs';

    protected $fillable = [
        'barang_id',
        'periode_bulan',
        'nilai_buku_awal',
        'nilai_penyusutan',
        'nilai_buku_akhir',
        'metode',
        'created_by'
    ];

    protected $casts = [
        'periode_bulan' => 'date',
        'nilai_buku_awal' => 'decimal:2',
        'nilai_penyusutan' => 'decimal:2',
        'nilai_buku_akhir' => 'decimal:2',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}