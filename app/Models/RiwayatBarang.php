<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model RiwayatBarang
 * 
 * Mencatat log transaksi keluar/masuk barang inventaris.
 * Berguna untuk audit stok aset.
 */
class RiwayatBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',        // Barang yang transaksikan
        'user_id',          // User yang melakukan transaksi (penanggung jawab)
        'jenis_transaksi',  // Masuk / Keluar
        'jumlah',           // Jumlah barang
        'stok_terakhir',    // Snapshot stok setelah transaksi
        'tanggal',          // Tanggal transaksi
        'keterangan'        // Alasan transaksi (e.g. Pembelian baru, Rusak, Dipinjam)
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}