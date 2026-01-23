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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pegawai dengan akun user login
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('ID User yang berelasi');
            
            $table->string('nip')->unique()->comment('Nomor Induk Pegawai');
            $table->string('jabatan')->comment('Jabatan fungsional atau struktural');
            $table->string('no_telepon')->nullable()->comment('Nomor telepon aktif');
            $table->text('alamat')->nullable()->comment('Alamat tempat tinggal');
            $table->string('status_kepegawaian')->default('Honor')->comment('Status kepegawaian (PNS, PPPK, Honor, Kontrak, Tetap, Magang)');
            $table->date('tanggal_masuk')->nullable()->comment('Tanggal mulai bekerja');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};