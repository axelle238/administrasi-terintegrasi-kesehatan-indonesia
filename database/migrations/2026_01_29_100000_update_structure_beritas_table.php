<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('konten');
            $table->string('thumbnail')->nullable();
            $table->string('kategori')->default('Umum');
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['judul', 'slug', 'konten', 'thumbnail', 'kategori', 'status', 'user_id']);
        });
    }
};