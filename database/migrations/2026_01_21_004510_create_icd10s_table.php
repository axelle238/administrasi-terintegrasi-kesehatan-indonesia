<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('icd10s')) {
            Schema::create('icd10s', function (Blueprint $table) {
                $table->id();
                $table->string('code', 10)->unique()->index(); // Kode ICD (misal: A01.0)
                $table->string('name_id', 500); // Nama Indonesia
                $table->string('name_en', 500)->nullable(); // Nama Inggris (Standar WHO)
                $table->boolean('is_bpjs')->default(true); // Apakah ditanggung BPJS
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('icd10s');
    }
};