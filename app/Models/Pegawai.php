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
        'user_id',          
        'nip',              
        'nik',
        'kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'status_pernikahan',
        'jabatan',          
        'poli_id',          
        'no_telepon',       
        'alamat',           
        'status_kepegawaian', 
        'tanggal_masuk',
        'tanggal_berhenti',
        'alasan_berhenti',
        'is_active',    
        'no_str',           
        'masa_berlaku_str', 
        'no_sip',           
        'masa_berlaku_sip',
        'npwp',
        'nama_bank',
        'nomor_rekening',
        'pemilik_rekening',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan', 
        'file_str',         
        'file_sip',         
        'file_ijazah',      
        'file_sertifikat_pelatihan', 
        'kuota_cuti_tahunan',
        'sisa_cuti',
        'foto_profil',
        'kontak_darurat_nama',
        'kontak_darurat_relasi',
        'kontak_darurat_telp', // Sesuai kolom database lama
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

    /**
     * Relasi: Riwayat Karir / Jabatan.
     */
    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatanPegawai::class)->orderByDesc('tanggal_mulai');
    }

    /**
     * Relasi: Keluarga Pegawai.
     */
    public function keluarga()
    {
        return $this->hasMany(KeluargaPegawai::class);
    }

    /**
     * Relasi: Riwayat Pendidikan Formal.
     */
    public function pendidikan()
    {
        return $this->hasMany(RiwayatPendidikanPegawai::class)->orderByDesc('tahun_lulus');
    }

    /**
     * Relasi: Dokumen Digital / Arsip.
     */
    public function dokumen()
    {
        return $this->hasMany(DokumenPegawai::class);
    }

    /**
     * Relasi: Catatan Pelanggaran & Sanksi.
     */
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class)->orderByDesc('tanggal_kejadian');
    }

    /**
     * Relasi: Aset / Inventaris yang dipegang pegawai.
     */
    public function aset()
    {
        return $this->hasMany(AsetPegawai::class)->where('status', 'Dipakai');
    }
}