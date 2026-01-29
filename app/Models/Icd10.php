<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model
{
    use HasFactory;

    protected $table = 'icd10s';

    protected $fillable = [
        'code',
        'name_id',
        'name_en',
        'is_bpjs',
        'active',
    ];

    // Scope untuk pencarian cepat
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($q) use ($term) {
            $q->where('code', 'like', $term)
              ->orWhere('name_id', 'like', $term)
              ->orWhere('name_en', 'like', $term);
        });
    }
}