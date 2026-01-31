<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Models\JadwalJaga;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $todayPresensi;
    public $latitude;
    public $longitude;
    public $currentStep = 'check-in'; // check-in, working, check-out, done

    public function mount()
    {
        $this->checkTodayStatus();
    }

    public function checkTodayStatus()
    {
        $this->todayPresensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (!$this->todayPresensi) {
            $this->currentStep = 'check-in';
        } elseif ($this->todayPresensi->jam_masuk && !$this->todayPresensi->jam_keluar) {
            $this->currentStep = 'check-out';
        } else {
            $this->currentStep = 'done';
        }
    }

    public function clockIn($lat, $long)
    {
        // Validasi Lokasi (Optional: Geofencing Logic here)
        // Untuk sekarang kita simpan saja koordinatnya
        
        // Cek Jadwal untuk hitung keterlambatan
        $jadwal = JadwalJaga::with('shift')
            ->where('pegawai_id', Auth::user()->pegawai->id ?? 0)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $lateMinutes = 0;
        $status = 'Hadir';

        if ($jadwal) {
            $shiftStart = Carbon::parse($jadwal->tanggal . ' ' . $jadwal->shift->jam_masuk);
            $now = Carbon::now();
            
            if ($now->gt($shiftStart)) {
                $lateMinutes = $now->diffInMinutes($shiftStart);
                $status = 'Terlambat';
            }
        }

        Presensi::create([
            'user_id' => Auth::id(),
            'tanggal' => Carbon::today(),
            'jam_masuk' => Carbon::now(),
            'lokasi_masuk' => "$lat,$long",
            'status_kehadiran' => $status,
            'keterlambatan_menit' => $lateMinutes,
            // Foto masuk akan dihandle via upload terpisah jika perlu, 
            // disini kita asumsikan capture base64 dikirim via parameter (simplified for CLI)
        ]);

        $this->dispatch('notify', 'success', 'Berhasil Absen Masuk! Selamat Bekerja.');
        $this->checkTodayStatus();
    }

    public function clockOut($lat, $long)
    {
        if ($this->todayPresensi) {
            $this->todayPresensi->update([
                'jam_keluar' => Carbon::now(),
                'lokasi_keluar' => "$lat,$long",
            ]);
            
            $this->dispatch('notify', 'success', 'Berhasil Absen Pulang. Hati-hati di jalan!');
            $this->checkTodayStatus();
        }
    }

    public function render()
    {
        $history = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', Carbon::now()->month)
            ->orderByDesc('tanggal')
            ->get();

        return view('livewire.kepegawaian.presensi.index', [
            'history' => $history
        ])->layout('layouts.app', ['header' => 'Presensi Digital']);
    }
}
