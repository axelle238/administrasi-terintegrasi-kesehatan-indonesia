<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tindakan',
        'kategori',
        'deskripsi',
        'harga',
        'is_active',
        'poli_id'
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}