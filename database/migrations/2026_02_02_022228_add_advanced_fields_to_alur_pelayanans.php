<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            // Finansial
            if (!Schema::hasColumn('alur_pelayanans', 'biaya_sarana')) {
                $table->decimal('biaya_sarana', 12, 2)->default(0)->after('estimasi_biaya');
            }
            if (!Schema::hasColumn('alur_pelayanans', 'biaya_pelayanan')) {
                $table->decimal('biaya_pelayanan', 12, 2)->default(0)->after('biaya_sarana');
            }
            
            // Operasional Waktu (Range)
            if (!Schema::hasColumn('alur_pelayanans', 'waktu_min')) {
                $table->integer('waktu_min')->nullable()->comment('Menit')->after('estimasi_waktu');
            }
            if (!Schema::hasColumn('alur_pelayanans', 'waktu_max')) {
                $table->integer('waktu_max')->nullable()->comment('Menit')->after('waktu_min');
            }

            // Resource (Siapa yang mengerjakan?)
            if (!Schema::hasColumn('alur_pelayanans', 'required_role_id')) {
                $table->unsignedBigInteger('required_role_id')->nullable()->after('penanggung_jawab');
                // Tidak di-constrain strict agar tidak error jika role dihapus, tapi idealnya constrained.
                // Kita index saja untuk performa.
                $table->index('required_role_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn(['biaya_sarana', 'biaya_pelayanan', 'waktu_min', 'waktu_max', 'required_role_id']);
        });
    }
};