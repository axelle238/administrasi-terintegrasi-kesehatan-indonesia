<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'lokasi_asal',
        'lokasi_tujuan',
        'ruangan_id_asal',
        'ruangan_id_tujuan',
        'jumlah',
        'tanggal_mutasi',
        'penanggung_jawab',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruanganAsal(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id_asal');
    }

    public function ruanganTujuan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id_tujuan');
    }
}
