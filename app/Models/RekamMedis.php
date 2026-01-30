<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Model RekamMedis
 * 
 * Inti dari data klinis. Menyimpan hasil pemeriksaan dokter (SOAP).
 * Menghubungkan Pasien, Dokter, Obat (Resep), dan Tindakan.
 */
class RekamMedis extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'pasien_id',        // ID Pasien
        'dokter_id',        // ID User Dokter pemeriksa
        'tanggal_periksa',  // Waktu pemeriksaan
        
        // SOAP (Subjective, Objective, Assessment, Plan)
        'keluhan',          // Anamnesa (Subjective)
        'diagnosa',         // Diagnosa medis (Assessment)
        'catatan_tambahan', // Plan / Instruksi lain
        
        // Vital Signs (Objective)
        'tekanan_darah',
        'suhu_tubuh',
        'berat_badan',
        'tinggi_badan',
        'nadi',
        'pernapasan',
        
        'status_resep',     // Status penebusan obat: Menunggu, Selesai
        'status_pemeriksaan', // Status flow: Dalam Proses, Selesai
        'odontogram',       // Data JSON untuk status gigi
    ];

    /**
     * Casts attributes.
     */
    protected $casts = [
        'odontogram' => 'array',
        'tanggal_periksa' => 'datetime',
    ];

    /**
     * Relasi: Rekam Medis milik satu Pasien.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relasi: Rekam Medis diperiksa oleh satu Dokter.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    /**
     * Relasi: Obat yang diresepkan dalam pemeriksaan ini.
     * Many-to-Many dengan data tambahan di pivot (jumlah, aturan pakai).
     */
    public function obats(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'rekam_medis_obat')
                    ->withPivot('jumlah', 'aturan_pakai')
                    ->withTimestamps();
    }

    /**
     * Relasi: Tindakan medis yang dilakukan.
     * Many-to-Many dengan data tambahan di pivot (biaya saat itu).
     */
    public function tindakans(): BelongsToMany
    {
        return $this->belongsToMany(Tindakan::class, 'rekam_medis_tindakan')
                    ->withPivot('biaya')
                    ->withTimestamps();
    }

    /**
     * Relasi: Pembayaran/Tagihan terkait pemeriksaan ini.
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }

    /**
     * Relasi: File pendukung (Lab, Rontgen).
     */
    public function files(): HasMany
    {
        return $this->hasMany(RekamMedisFile::class);
    }

    public function laboratoriums(): HasMany
    {
        return $this->hasMany(Laboratorium::class);
    }
}