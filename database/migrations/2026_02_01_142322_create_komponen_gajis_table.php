<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_gajis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_komponen'); // Tunjangan Makan, Potongan Koperasi
            $table->enum('jenis', ['Penerimaan', 'Potongan']);
            $table->decimal('nilai_default', 15, 2)->default(0);
            $table->boolean('is_taxable')->default(true); // Kena Pajak?
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen_gajis');
    }
};