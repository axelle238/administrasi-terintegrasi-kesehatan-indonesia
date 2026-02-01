<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelayanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function alurPelayanans()
    {
        return $this->hasMany(AlurPelayanan::class)->orderBy('urutan');
    }
}