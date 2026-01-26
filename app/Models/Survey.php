<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'poli_id',
        'nilai',
        'kritik_saran',
        'ip_address',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
