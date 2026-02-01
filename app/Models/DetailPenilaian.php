<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerja::class, 'indikator_id');
    }
}