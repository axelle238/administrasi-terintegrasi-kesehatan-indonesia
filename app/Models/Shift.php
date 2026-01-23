<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['nama_shift', 'jam_mulai', 'jam_selesai'];

    public function jadwalJagas(): HasMany
    {
        return $this->hasMany(JadwalJaga::class);
    }
}