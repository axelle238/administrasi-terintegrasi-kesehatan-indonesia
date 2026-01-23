<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObatBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'batch_number',
        'tanggal_kedaluwarsa',
        'stok',
        'harga_beli'
    ];

    protected $casts = [
        'tanggal_kedaluwarsa' => 'date',
    ];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}