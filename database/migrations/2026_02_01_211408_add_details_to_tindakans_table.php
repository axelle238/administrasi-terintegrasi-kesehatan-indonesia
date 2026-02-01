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
        Schema::table('tindakans', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('nama_tindakan')->comment('Kategori layanan: Umum, Gigi, Laboratorium, dll');
            $table->text('deskripsi')->nullable()->after('kategori')->comment('Penjelasan singkat untuk publik');
            $table->boolean('is_active')->default(true)->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tindakans', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'deskripsi', 'is_active']);
        });
    }
};