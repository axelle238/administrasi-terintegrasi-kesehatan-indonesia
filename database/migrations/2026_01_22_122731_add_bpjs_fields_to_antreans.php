<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->string('no_kunjungan_bpjs')->nullable()->after('nomor_antrean');
            $table->string('kode_booking')->nullable()->after('no_kunjungan_bpjs'); // Untuk Mobile JKN
            $table->integer('task_id_last')->default(0)->after('kode_booking');
        });
    }

    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn(['no_kunjungan_bpjs', 'kode_booking', 'task_id_last']);
        });
    }
};