<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_dokumen',
        'nama_dokumen',
        'file_path',
        'tanggal_kadaluwarsa',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}