<?php

namespace App\Services;

use App\Models\Presensi;
use App\Models\LaporanHarian;
use App\Models\JadwalJaga;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiService
{
    public function absenMasuk($userId, $data)
    {
        $today = Carbon::today();
        $now = Carbon::now();
        $kategori = $data['kategori'] ?? 'WFO'; // Bisa: WFO, WFH, Dinas Luar Awal, Dinas Luar Akhir, Dinas Luar Penuh

        // 1. Ambil Jadwal Shift Hari Ini
        $jadwal = JadwalJaga::with('shift')
            ->whereHas('pegawai', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereDate('tanggal', $today)
            ->first();
            
        $shiftInfo = [
            'shift_nama' => $jadwal ? $jadwal->shift->nama_shift : 'Reguler',
            'shift_jam_masuk' => $jadwal ? $jadwal->shift->jam_masuk : '08:00:00',
            'shift_jam_keluar' => $jadwal ? $jadwal->shift->jam_keluar : '16:00:00',
        ];

        // 2. Simpan Presensi
        $presensi = Presensi::updateOrCreate(
            ['user_id' => $userId, 'tanggal' => $today],
            [
                'jam_masuk' => $now,
                'kategori' => $kategori, 
                'foto_masuk' => $data['foto'] ?? null,
                'koordinat_masuk' => $data['koordinat'] ?? null,
                'alamat_masuk' => $data['alamat'] ?? null,
                'shift_nama' => $shiftInfo['shift_nama'],
                'shift_jam_masuk' => $shiftInfo['shift_jam_masuk'],
                'shift_jam_keluar' => $shiftInfo['shift_jam_keluar'],
                // Logika Status: Jika DL, dianggap Tepat Waktu (Kompensasi), kecuali WFO/WFH dicek jamnya
                'status_masuk' => str_contains($kategori, 'Dinas Luar') ? 'Tepat Waktu' : ($now->format('H:i:s') > $shiftInfo['shift_jam_masuk'] ? 'Terlambat' : 'Tepat Waktu'),
                'terlambat_menit' => str_contains($kategori, 'Dinas Luar') ? 0 : max(0, $now->diffInMinutes(Carbon::parse($shiftInfo['shift_jam_masuk']), false))
            ]
        );

        // 3. INTEGRASI OTOMATIS: Buat Draft Laporan Aktivitas
        $deskripsiKegiatan = match($kategori) {
            'Dinas Luar Awal' => 'Melaksanakan Tugas Dinas Luar (Sesi Pagi)',
            'Dinas Luar Akhir' => 'Melaksanakan Tugas Dinas Luar (Sesi Siang/Sore)',
            'Dinas Luar Penuh' => 'Melaksanakan Tugas Dinas Luar (Seharian Penuh)',
            'WFH' => 'Bekerja dari Rumah (Work From Home)',
            default => 'Presensi Masuk Kantor (WFO)'
        };

        $laporan = LaporanHarian::firstOrCreate(
            ['user_id' => $userId, 'tanggal' => $today],
            [
                'status' => 'Draft',
                'catatan_harian' => $deskripsiKegiatan . ' di ' . ($data['alamat'] ?? 'Lokasi Tugas')
            ]
        );

        // Logika Waktu Laporan Aktivitas (Sesuai Kompensasi Waktu)
        $jamMulaiKegiatan = $now->format('H:i');
        $jamSelesaiKegiatan = Carbon::parse($shiftInfo['shift_jam_keluar'])->format('H:i');

        if ($kategori === 'Dinas Luar Awal') {
            $jamMulaiKegiatan = '07:30'; 
            $jamSelesaiKegiatan = '12:00';
        } elseif ($kategori === 'Dinas Luar Akhir') {
            $jamMulaiKegiatan = '12:00';
            $jamSelesaiKegiatan = '16:00'; // Atau jam pulang shift
        } elseif ($kategori === 'Dinas Luar Penuh') {
            $jamMulaiKegiatan = '07:30';
            $jamSelesaiKegiatan = '16:00';
        }

        // Hindari duplikasi jika user klik absen berkali-kali di hari yang sama
        // Cek apakah sudah ada detail serupa
        $detailExists = $laporan->details()
            ->where('kegiatan', 'like', '%Dinas Luar%')
            ->exists();

        if (str_contains($kategori, 'Dinas Luar') && !$detailExists) {
            $laporan->details()->create([
                'jam_mulai' => $jamMulaiKegiatan,
                'jam_selesai' => $jamSelesaiKegiatan,
                'kegiatan' => $deskripsiKegiatan,
                'output' => 'Laporan Hasil Pelaksanaan Tugas',
                'progress' => 0, 
                'kategori' => 'Utama'
            ]);
        } elseif ($kategori === 'WFH' && !$laporan->details()->exists()) {
             $laporan->details()->create([
                'jam_mulai' => $now->format('H:i'),
                'jam_selesai' => $now->addHour()->format('H:i'), 
                'kegiatan' => 'Koordinasi Tim & Cek Email (WFH)',
                'output' => 'Log Aktivitas',
                'progress' => 100,
                'kategori' => 'Utama'
            ]);
        }

        return $presensi;
    }

    public function absenKeluar($userId, $data)
    {
        $today = Carbon::today();
        $now = Carbon::now();

        $presensi = Presensi::where('user_id', $userId)->whereDate('tanggal', $today)->first();

        if (!$presensi) {
            throw new \Exception("Anda belum melakukan absensi masuk hari ini.");
        }

        $jamMasuk = Carbon::parse($presensi->jam_masuk);
        $totalKerja = $now->diffInMinutes($jamMasuk);

        // Update Data Presensi
        $presensi->update([
            'jam_keluar' => $now,
            'foto_keluar' => $data['foto'] ?? null,
            'koordinat_keluar' => $data['koordinat'] ?? null,
            'alamat_keluar' => $data['alamat'] ?? null,
            'status_keluar' => $now->format('H:i:s') < $presensi->shift_jam_keluar ? 'Pulang Cepat' : 'Normal',
            'pulang_cepat_menit' => max(0, Carbon::parse($presensi->shift_jam_keluar)->diffInMinutes($now, false) * -1),
            'total_jam_kerja_menit' => $totalKerja
        ]);
        
        // Auto-Update Laporan jika Dinas Luar (Selesaikan progress otomatis saat absen pulang)
        if (str_contains($presensi->kategori, 'Dinas Luar')) {
            $laporan = LaporanHarian::where('user_id', $userId)->whereDate('tanggal', $today)->first();
            if($laporan) {
                $laporan->details()
                    ->where('kegiatan', 'like', '%Dinas Luar%')
                    ->update(['progress' => 100]);
            }
        }

        return $presensi;
    }
}