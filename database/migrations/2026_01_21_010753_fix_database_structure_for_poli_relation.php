<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix Antreans
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn('poli_tujuan'); // Drop string column
            $table->foreignId('poli_id')->nullable()->constrained('polis')->onDelete('cascade')->after('pasien_id');
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null')->after('poli_id'); // Lock mechanism
        });

        // Fix Tindakans
        Schema::table('tindakans', function (Blueprint $table) {
            $table->dropColumn('poli_terkait'); // Drop string column
            $table->foreignId('poli_id')->nullable()->constrained('polis')->onDelete('cascade')->after('nama_tindakan');
        });
    }

    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->string('poli_tujuan')->nullable();
            $table->dropForeign(['poli_id']);
            $table->dropColumn('poli_id');
            $table->dropForeign(['dokter_id']);
            $table->dropColumn('dokter_id');
        });

        Schema::table('tindakans', function (Blueprint $table) {
            $table->string('poli_terkait')->nullable();
            $table->dropForeign(['poli_id']);
            $table->dropColumn('poli_id');
        });
    }
};