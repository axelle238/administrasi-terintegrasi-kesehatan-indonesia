<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model PengajuanCuti
 * 
 * Mengelola permohonan izin/cuti pegawai.
 */
class PengajuanCuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'status',
        'catatan_admin'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}