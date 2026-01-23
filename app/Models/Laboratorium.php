<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    use HasFactory;

    protected $fillable = ['rekam_medis_id', 'jenis_pemeriksaan', 'hasil', 'petugas_lab', 'waktu_selesai'];

    protected $casts = [
        'hasil' => 'array',
        'waktu_selesai' => 'datetime',
    ];
}