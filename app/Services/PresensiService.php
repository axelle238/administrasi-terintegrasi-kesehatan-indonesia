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
        $kategori = $data['kategori'] ?? 'WFO'; // Default WFO

        // 1. Ambil Jadwal Shift Hari Ini
        $jadwal = JadwalJaga::with('shift')
            ->where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();
            
        $shiftInfo = [
            'shift_nama' => $jadwal ? $jadwal->shift->nama_shift : 'Reguler',
            'shift_jam_masuk' => $jadwal ? $jadwal->shift->jam_masuk : '08:00:00',
            'shift_jam_keluar' => $jadwal ? $jadwal->shift->jam_keluar : '16:00:00',
        ];

        // 2. Simpan Presensi (Integrasi Data Kehadiran)
        $presensi = Presensi::updateOrCreate(
            ['user_id' => $userId, 'tanggal' => $today],
            [
                'jam_masuk' => $now,
                'kategori' => $kategori, // WFO / DL / WFH
                'foto_masuk' => $data['foto'] ?? null,
                'koordinat_masuk' => $data['koordinat'] ?? null,
                'alamat_masuk' => $data['alamat'] ?? null,
                'shift_nama' => $shiftInfo['shift_nama'],
                'shift_jam_masuk' => $shiftInfo['shift_jam_masuk'],
                'shift_jam_keluar' => $shiftInfo['shift_jam_keluar'],
                'status_masuk' => $now->format('H:i:s') > $shiftInfo['shift_jam_masuk'] ? 'Terlambat' : 'Tepat Waktu',
                'terlambat_menit' => max(0, $now->diffInMinutes(Carbon::parse($shiftInfo['shift_jam_masuk']), false))
            ]
        );

        // 3. INTEGRASI OTOMATIS: Buat Draft Laporan Aktivitas
        // Logic Cerdas berdasarkan Kategori
        $catatanAwal = match($kategori) {
            'Dinas Luar' => 'Melaksanakan Tugas Dinas Luar di ' . ($data['alamat'] ?? 'Lokasi Tujuan'),
            'WFH' => 'Bekerja dari Rumah (Work From Home)',
            default => 'Presensi Masuk Kantor (WFO). Siap melaksanakan tugas rutin.'
        };

        $laporan = LaporanHarian::firstOrCreate(
            ['user_id' => $userId, 'tanggal' => $today],
            [
                'status' => 'Draft',
                'catatan_harian' => $catatanAwal
            ]
        );

        // Jika Dinas Luar, langsung buatkan item kegiatan spesifik
        if ($kategori === 'Dinas Luar') {
            $laporan->details()->create([
                'jam_mulai' => $now->format('H:i'),
                'jam_selesai' => Carbon::parse($shiftInfo['shift_jam_keluar'])->format('H:i'), // Estimasi sampai pulang
                'kegiatan' => 'Perjalanan dan Pelaksanaan Dinas Luar',
                'output' => 'Laporan Hasil Dinas',
                'progress' => 0, // Mulai dari 0
                'kategori' => 'Utama'
            ]);
        } elseif ($kategori === 'WFH') {
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

        $presensi->update([
            'jam_keluar' => $now,
            'foto_keluar' => $data['foto'] ?? null,
            'koordinat_keluar' => $data['koordinat'] ?? null,
            'alamat_keluar' => $data['alamat'] ?? null,
            'status_keluar' => $now->format('H:i:s') < $presensi->shift_jam_keluar ? 'Pulang Cepat' : 'Normal',
            'pulang_cepat_menit' => max(0, Carbon::parse($presensi->shift_jam_keluar)->diffInMinutes($now, false) * -1),
            'total_jam_kerja_menit' => $totalKerja
        ]);
        
        // Auto-Update Laporan jika Dinas Luar (Selesaikan progress)
        if ($presensi->kategori === 'Dinas Luar') {
            $laporan = LaporanHarian::where('user_id', $userId)->whereDate('tanggal', $today)->first();
            if($laporan) {
                $laporan->details()
                    ->where('kegiatan', 'like', '%Dinas Luar%')
                    ->update(['progress' => 100, 'jam_selesai' => $now->format('H:i')]);
            }
        }

        return $presensi;
    }
}