<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected $fillable = [
        'nama_supplier',
        'kode_supplier',
        'kontak_person',
        'telepon',
        'email',
        'alamat',
        'keterangan',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
    
    public function pengadaanBarangs()
    {
        return $this->hasMany(PengadaanBarang::class);
    }
}