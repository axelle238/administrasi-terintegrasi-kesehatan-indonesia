<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengadaanBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengajuan',
        'tanggal_pengajuan',
        'pemohon_id',
        'status', // Pending, Approved, Rejected, Received
        'keterangan',
        'catatan_persetujuan',
        'disetujui_oleh',
        'tanggal_disetujui'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PengadaanBarangDetail::class);
    }

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}