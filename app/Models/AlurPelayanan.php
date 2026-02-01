<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurPelayanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_critical' => 'boolean',
        'faq' => 'array',
        'tags' => 'array',
        'estimasi_biaya' => 'decimal:2',
    ];

    public function jenisPelayanan()
    {
        return $this->belongsTo(JenisPelayanan::class);
    }
}