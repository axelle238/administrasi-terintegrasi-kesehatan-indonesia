<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pembayaran extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    protected $fillable = [
        'no_transaksi', 'rekam_medis_id', 'pasien_id', 'total_biaya_tindakan', 'total_biaya_obat', 'biaya_administrasi', 'total_tagihan', 'metode_pembayaran', 'jumlah_bayar', 'kembalian', 'status', 'kasir_id'
    ];

    public function rekamMedis() { return $this->belongsTo(RekamMedis::class); }
    public function pasien() { return $this->belongsTo(Pasien::class); }
}