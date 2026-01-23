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
            $table->string('file_str')->nullable()->after('masa_berlaku_sip');
            $table->string('file_sip')->nullable()->after('file_str');
            $table->string('file_ijazah')->nullable()->after('file_sip');
            $table->string('file_sertifikat_pelatihan')->nullable()->after('file_ijazah'); // Could be JSON for multiple
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['file_str', 'file_sip', 'file_ijazah', 'file_sertifikat_pelatihan']);
        });
    }
};