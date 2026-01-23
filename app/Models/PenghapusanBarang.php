<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_dokumen',
        'tanggal_pengajuan',
        'diajukan_oleh',
        'disetujui_oleh',
        'tanggal_disetujui',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(PenghapusanBarangDetail::class);
    }

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function penyetuju()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}