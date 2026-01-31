<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertukaranJadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemohon_id',
        'pengganti_id',
        'jadwal_asal_id',
        'jadwal_tujuan_id',
        'alasan',
        'status',
        'catatan_approval'
    ];

    public function pemohon() { return $this->belongsTo(User::class, 'pemohon_id'); }
    public function pengganti() { return $this->belongsTo(User::class, 'pengganti_id'); }
    public function jadwalAsal() { return $this->belongsTo(JadwalJaga::class, 'jadwal_asal_id'); }
    public function jadwalTujuan() { return $this->belongsTo(JadwalJaga::class, 'jadwal_tujuan_id'); }
}
