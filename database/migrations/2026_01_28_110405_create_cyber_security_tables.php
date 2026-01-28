<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk mencatat riwayat login user (Session Management)
        Schema::create('riwayat_login', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('waktu_login')->useCurrent();
            $table->timestamp('waktu_logout')->nullable();
            $table->string('status')->default('Berhasil'); // Berhasil, Gagal, Terblokir
            $table->timestamps();
        });

        // Tabel untuk IP yang diblokir (Firewall Sederhana)
        Schema::create('ip_diblokir', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->string('alasan')->nullable(); // Brute Force, Suspicious, Manual
            $table->timestamp('diblokir_sampai')->nullable(); // Null = Permanen
            $table->foreignId('diblokir_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabel Pengaturan Keamanan Lanjutan
        Schema::create('pengaturan_keamanan', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique(); // max_login_attempts, lockout_time, password_expiry_days
            $table->string('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_keamanan');
        Schema::dropIfExists('ip_diblokir');
        Schema::dropIfExists('riwayat_login');
    }
};