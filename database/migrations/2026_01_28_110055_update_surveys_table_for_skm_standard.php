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
        Schema::table('surveys', function (Blueprint $table) {
            // Menambahkan kolom untuk 9 unsur SKM
            // Nilai 1-4 (Sangat Buruk, Buruk, Baik, Sangat Baik)
            $table->tinyInteger('u1_persyaratan')->nullable()->after('poli_id');
            $table->tinyInteger('u2_prosedur')->nullable()->after('u1_persyaratan');
            $table->tinyInteger('u3_waktu')->nullable()->after('u2_prosedur');
            $table->tinyInteger('u4_biaya')->nullable()->after('u3_waktu');
            $table->tinyInteger('u5_produk')->nullable()->after('u4_biaya');
            $table->tinyInteger('u6_kompetensi')->nullable()->after('u5_produk');
            $table->tinyInteger('u7_perilaku')->nullable()->after('u6_kompetensi');
            $table->tinyInteger('u8_maklumat')->nullable()->after('u7_perilaku');
            $table->tinyInteger('u9_penanganan')->nullable()->after('u8_maklumat');
            
            // Profil Responden Sederhana
            $table->string('umur')->nullable()->after('u9_penanganan');
            $table->string('jenis_kelamin')->nullable()->after('umur');
            $table->string('pendidikan')->nullable()->after('jenis_kelamin');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn([
                'u1_persyaratan', 'u2_prosedur', 'u3_waktu', 
                'u4_biaya', 'u5_produk', 'u6_kompetensi', 
                'u7_perilaku', 'u8_maklumat', 'u9_penanganan',
                'umur', 'jenis_kelamin', 'pendidikan', 'pekerjaan'
            ]);
        });
    }
};