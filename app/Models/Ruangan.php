<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ruangan extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'lokasi_gedung',
        'penanggung_jawab',
        'keterangan',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}