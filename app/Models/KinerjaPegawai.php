<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KinerjaPegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'orientasi_pelayanan',
        'integritas',
        'komitmen',
        'disiplin',
        'kerjasama',
        'catatan_atasan',
        'penilai'
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Helper untuk nilai rata-rata
    public function getNilaiRataRataAttribute()
    {
        return ($this->orientasi_pelayanan + $this->integritas + $this->komitmen + $this->disiplin + $this->kerjasama) / 5;
    }

    public function getNilaiRataRataAttribute()
    {
        return ($this->orientasi_pelayanan + $this->integritas + $this->komitmen + $this->disiplin + $this->kerjasama) / 5;
    }

    public function getPredikatAttribute()
    {
        $avg = $this->nilai_rata_rata;
        if ($avg >= 90) return 'Sangat Baik';
        if ($avg >= 75) return 'Baik';
        if ($avg >= 60) return 'Cukup';
        return 'Kurang';
    }
}