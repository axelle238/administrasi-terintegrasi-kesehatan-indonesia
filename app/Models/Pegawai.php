<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Pegawai
 * 
 * Menyimpan data detail kepegawaian yang terhubung dengan akun User.
 * Mencakup NIP, jabatan, dan data izin praktik medis (STR/SIP).
 */
class Pegawai extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    /**
     * Konfigurasi Log Aktivitas.
     * Mencatat perubahan pada semua atribut fillable.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'user_id',          // ID User terkait
        'nip',              // Nomor Induk Pegawai
        'jabatan',          // Jabatan struktural/fungsional
        'poli_id',          // Poli tempat bertugas (jika medis)
        'no_telepon',       // Kontak aktif
        'alamat',           // Alamat domisili
        'status_kepegawaian', // PNS, PPPK, Honor, dll
        'tanggal_masuk',    // TMT (Terhitung Mulai Tanggal)
        'no_str',           // Nomor Surat Tanda Registrasi (Medis)
        'masa_berlaku_str', // Expired date STR
        'no_sip',           // Nomor Surat Izin Praktik (Medis)
        'masa_berlaku_sip', // Expired date SIP
        'file_str',         // Path file STR
        'file_sip',         // Path file SIP
        'file_ijazah',      // Path file Ijazah
        'file_sertifikat_pelatihan', // Path file sertifikat (bisa multiple/zip)
        'kuota_cuti_tahunan',
        'sisa_cuti',
        'foto_profil',
        'kontak_darurat_nama',
        'kontak_darurat_telp',
    ];

    /**
     * Relasi: Pegawai milik satu User (Akun Login).
     * (BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Pegawai bertugas di satu Poli.
     */
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
}