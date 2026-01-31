<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarianDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function laporan()
    {
        return $this->belongsTo(LaporanHarian::class, 'laporan_harian_id');
    }
}