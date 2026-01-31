<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Upgrade LKH (Task Management)
        Schema::table('laporan_kinerja_harians', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_kinerja_harians', 'persentase_selesai')) {
                $table->integer('persentase_selesai')->default(0)->after('status');
                $table->text('kendala_teknis')->nullable()->after('persentase_selesai');
                $table->string('file_bukti_kerja')->nullable()->after('kendala_teknis');
                $table->string('prioritas')->default('Normal'); // Low, Normal, High, Urgent
            }
        });

        // 2. Tabel Riwayat Pelatihan (Kompetensi)
        if (!Schema::hasTable('riwayat_pelatihans')) {
            Schema::create('riwayat_pelatihans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('nama_pelatihan');
                $table->string('penyelenggara');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->integer('durasi_jam');
                $table->string('nomor_sertifikat')->nullable();
                $table->string('file_sertifikat')->nullable();
                $table->string('status')->default('Selesai'); // Direncanakan, Berjalan, Selesai
                $table->timestamps();
            });
        }

        // 3. Tabel Pertukaran Jadwal (Shift Swap)
        if (!Schema::hasTable('pertukaran_jadwals')) {
            Schema::create('pertukaran_jadwals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pemohon_id')->constrained('users'); // User yang minta tukar
                $table->foreignId('pengganti_id')->constrained('users'); // User yang diminta menggantikan
                $table->foreignId('jadwal_asal_id')->constrained('jadwal_jagas'); // Jadwal milik pemohon
                $table->foreignId('jadwal_tujuan_id')->constrained('jadwal_jagas'); // Jadwal milik pengganti
                $table->text('alasan');
                $table->string('status')->default('Menunggu Respon'); // Menunggu Respon, Disetujui Rekan, Disetujui Admin, Ditolak
                $table->text('catatan_approval')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pertukaran_jadwals');
        Schema::dropIfExists('riwayat_pelatihans');
        
        Schema::table('laporan_kinerja_harians', function (Blueprint $table) {
            $table->dropColumn(['persentase_selesai', 'kendala_teknis', 'file_bukti_kerja', 'prioritas']);
        });
    }
};