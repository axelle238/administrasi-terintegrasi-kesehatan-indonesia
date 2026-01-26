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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('email_pelapor')->nullable();
            $table->string('no_telepon_pelapor');
            $table->string('subjek');
            $table->text('isi_pengaduan');
            $table->string('status')->default('Pending'); // Pending, Diproses, Selesai
            $table->text('tanggapan')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};