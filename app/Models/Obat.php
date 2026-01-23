<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Obat extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected $fillable = [
        'kode_obat', 'nama_obat', 'jenis_obat', 'golongan', 'stok', 'satuan', 'harga_satuan', 'tanggal_kedaluwarsa', 'keterangan'
    ];

    public function batches()
    {
        return $this->hasMany(ObatBatch::class)->orderBy('tanggal_kedaluwarsa', 'asc');
    }

    /**
     * Recalculate total stock from batches
     */
    public function refreshStok()
    {
        $total = $this->batches()->sum('stok');
        // Get the nearest expiry date
        $nearestExp = $this->batches()->where('stok', '>', 0)->min('tanggal_kedaluwarsa');
        
        $this->update([
            'stok' => $total,
            'tanggal_kedaluwarsa' => $nearestExp ?? now()->addYears(10) // Fallback if no batch
        ]);
    }
}