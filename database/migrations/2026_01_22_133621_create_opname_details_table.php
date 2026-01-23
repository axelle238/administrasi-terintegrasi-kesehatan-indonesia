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
        Schema::create('opname_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opname_id')->constrained('opnames')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('stok_sistem');
            $table->integer('stok_fisik')->nullable();
            $table->integer('selisih')->nullable(); // stok_fisik - stok_sistem
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opname_details');
    }
};
