<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kredensial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Accessor: Cek Status
    public function getStatusMasaBerlakuAttribute()
    {
        if ($this->tanggal_berakhir->isPast()) {
            return 'Expired';
        }
        if ($this->tanggal_berakhir->diffInDays(now()) <= 90) {
            return 'Warning';
        }
        return 'Active';
    }
}