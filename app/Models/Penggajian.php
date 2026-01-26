<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penggajian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        
        // Detail Tunjangan
        'tunjangan_jabatan',
        'tunjangan_fungsional',
        'tunjangan_umum',
        'tunjangan_makan',
        'tunjangan_transport',
        'tunjangan', // Total Tunjangan

        // Detail Potongan
        'potongan_bpjs_kesehatan',
        'potongan_bpjs_tk',
        'potongan_pph21',
        'potongan_absen',
        'potongan', // Total Potongan

        'total_gaji', // Take Home Pay
        'status', // Paid, Pending
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}