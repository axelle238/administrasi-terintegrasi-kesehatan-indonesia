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
        'visibility_rules' => 'array',
        'estimasi_biaya' => 'decimal:2',
        'biaya_sarana' => 'decimal:2',
        'biaya_pelayanan' => 'decimal:2',
    ];

    public function jenisPelayanan()
    {
        return $this->belongsTo(JenisPelayanan::class);
    }

    public function requiredRole()
    {
        return $this->belongsTo(Role::class, 'required_role_id');
    }

    // Accessor: Total Biaya Real
    public function getTotalBiayaAttribute()
    {
        return $this->estimasi_biaya + $this->biaya_sarana + $this->biaya_pelayanan;
    }

    // Accessor: Estimasi Waktu String
    public function getWaktuRangeAttribute()
    {
        if ($this->waktu_min && $this->waktu_max) {
            return "{$this->waktu_min}-{$this->waktu_max} Menit";
        }
        return $this->estimasi_waktu;
    }
}