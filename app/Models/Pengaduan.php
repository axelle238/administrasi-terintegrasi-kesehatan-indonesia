<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_pelapor',
        'email_pelapor',
        'no_telepon_pelapor',
        'subjek',
        'isi_pengaduan',
        'status',
        'tanggapan',
        'file_lampiran'
    ];
}