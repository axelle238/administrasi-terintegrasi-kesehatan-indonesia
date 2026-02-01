<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasRoles;

/**
 * Model User
 * 
 * Merepresentasikan pengguna sistem (Administrator, Dokter, Perawat, dll).
 * Menggunakan Spatie Activitylog untuk mencatat perubahan data penting.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity, SoftDeletes, HasRoles;

    /**
     * Konfigurasi Log Aktivitas.
     * Hanya mencatat perubahan pada nama, email, dan role.
     * Hanya mencatat jika ada perubahan (dirty).
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'email', 'role'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Role pengguna: admin, dokter, perawat, apoteker, staf
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi (misal: response JSON API).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data atribut secara otomatis (Casting).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Password otomatis di-hash saat disimpan
        ];
    }

    /**
     * Relasi: User memiliki satu data detail Pegawai.
     * (One-to-One)
     */
    public function pegawai(): HasOne
    {
        return $this->hasOne(Pegawai::class);
    }

    /**
     * Relasi: User (jika Dokter) memiliki banyak rekam medis yang diperiksa.
     * (One-to-Many)
     */
    public function rekamMedis(): HasMany
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }

    /**
     * Relasi: User memiliki banyak riwayat login.
     * (One-to-Many)
     */
    public function riwayatLogins(): HasMany
    {
        return $this->hasMany(RiwayatLogin::class);
    }
}