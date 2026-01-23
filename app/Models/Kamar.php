<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'nama_bangsal',
        'kapasitas_bed',
        'bed_terisi',
        'is_kris_compliant',
        'harga_per_malam',
        'status'
    ];

    public function rawatInaps(): HasMany
    {
        return $this->hasMany(RawatInap::class);
    }
}