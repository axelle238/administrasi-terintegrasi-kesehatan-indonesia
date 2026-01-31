<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertukaranJadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemohon_id', 'jadwal_pemohon_id',
        'pengganti_id', 'jadwal_pengganti_id',
        'alasan', 'status', 'catatan_admin'
    ];

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function pengganti()
    {
        return $this->belongsTo(User::class, 'pengganti_id');
    }

    public function jadwalPemohon()
    {
        return $this->belongsTo(JadwalJaga::class, 'jadwal_pemohon_id');
    }

    public function jadwalPengganti()
    {
        return $this->belongsTo(JadwalJaga::class, 'jadwal_pengganti_id');
    }
}