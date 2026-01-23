<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('icd10s', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., A00.0
            $table->string('name_en'); // Cholera due to Vibrio cholerae 01, biovar cholerae
            $table->string('name_id')->nullable(); // Kolera akibat Vibrio cholerae 01, biovar cholerae
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icd10s');
    }
};