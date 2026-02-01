<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->string('jam_operasional')->nullable()->after('lokasi'); // e.g., "08:00 - 14:00"
            $table->json('tags')->nullable()->after('tipe_alur'); // Keywords pencarian: ["BPJS", "Lansia"]
            $table->text('internal_notes')->nullable()->after('is_active'); // Catatan khusus admin (tidak tampil di publik)
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn(['jam_operasional', 'tags', 'internal_notes']);
        });
    }
};