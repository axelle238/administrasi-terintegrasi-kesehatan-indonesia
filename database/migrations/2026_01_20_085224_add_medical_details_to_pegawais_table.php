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
        Schema::table('pegawais', function (Blueprint $table) {
            $table->string('no_str')->nullable()->after('status_kepegawaian')->comment('Nomor Surat Tanda Registrasi (Tenaga Medis)');
            $table->date('masa_berlaku_str')->nullable()->after('no_str');
            $table->string('no_sip')->nullable()->after('masa_berlaku_str')->comment('Nomor Surat Izin Praktik');
            $table->date('masa_berlaku_sip')->nullable()->after('no_sip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['no_str', 'masa_berlaku_str', 'no_sip', 'masa_berlaku_sip']);
        });
    }
};