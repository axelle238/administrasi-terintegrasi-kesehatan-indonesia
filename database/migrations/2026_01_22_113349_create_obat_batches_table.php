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
        Schema::create('obat_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->string('batch_number');
            $table->date('tanggal_kedaluwarsa');
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->timestamps();
            
            // Unique batch number per drug
            $table->unique(['obat_id', 'batch_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_batches');
    }
};