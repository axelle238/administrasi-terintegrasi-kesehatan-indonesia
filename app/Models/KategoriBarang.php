<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model KategoriBarang
 * 
 * Pengelompokan barang inventaris non-medis (Alat Tulis, Elektronik, Mebel, dll).
 */
class KategoriBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi: Kategori memiliki banyak Barang.
     * (One-to-Many)
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}