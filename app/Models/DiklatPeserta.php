<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiklatPeserta extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function diklat()
    {
        return $this->belongsTo(Diklat::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}