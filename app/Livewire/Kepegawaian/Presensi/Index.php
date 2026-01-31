<?php

namespace App\Livewire\Kepegawaian\Presensi;

use App\Models\Presensi;
use App\Models\JadwalJaga;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Index extends Component
{
    public $todayPresensi;
    public $currentStep = 'check-in'; // check-in, check-out, done
    public $history;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
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

        $this->history = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', Carbon::now()->month)
            ->orderByDesc('tanggal')
            ->get();
    }

    public function clockIn($lat, $lng)
    {
        // 1. Cek Jadwal
        $pegawai = Pegawai::where('user_id', Auth::id())->first();
        $jadwal = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawai->id ?? 0)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        $status = 'Hadir';
        $keterlambatan = 0;

        if ($jadwal) {
            $jamMasukJadwal = Carbon::parse($jadwal->shift->jam_masuk);
            $jamSekarang = Carbon::now();
            
            // Toleransi 15 menit
            if ($jamSekarang->gt($jamMasukJadwal->addMinutes(15))) {
                $status = 'Terlambat';
                $keterlambatan = $jamMasukJadwal->diffInMinutes($jamSekarang);
            }
        }

        Presensi::create([
            'user_id' => Auth::id(),
            'tanggal' => Carbon::today(),
            'jam_masuk' => Carbon::now(),
            'lokasi_masuk' => $lat . ',' . $lng,
            'status_kehadiran' => $status,
            'keterlambatan_menit' => $keterlambatan,
        ]);

        $this->dispatch('notify', 'success', 'Berhasil Absen Masuk! Semangat bekerja.');
        $this->refreshData();
    }

    public function clockOut($lat, $lng)
    {
        if ($this->todayPresensi) {
            $this->todayPresensi->update([
                'jam_keluar' => Carbon::now(),
                'lokasi_keluar' => $lat . ',' . $lng,
            ]);
            
            $this->dispatch('notify', 'success', 'Berhasil Absen Pulang. Hati-hati di jalan!');
            $this->refreshData();
        }
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.index')
            ->layout('layouts.app', ['header' => 'Presensi Digital']);
    }
}