<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisposisiSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_id',
        'pengirim_id',
        'penerima_id',
        'sifat_disposisi',
        'batas_waktu',
        'instruksi',
        'catatan',
        'status',
    ];

    protected $casts = [
        'batas_waktu' => 'date',
    ];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}