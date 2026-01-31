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
    
    // Fitur Baru: Jenis Presensi Dinamis
    public $jenis_presensi = 'WFO'; // Default
    public $keterangan_tambahan;

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
            $this->jenis_presensi = $this->todayPresensi->jenis_presensi; // Load existing type for checkout
        } else {
            $this->currentStep = 'done';
        }

        $this->history = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', Carbon::now()->month)
            ->orderByDesc('tanggal')
            ->get();
    }

    public function setJenis($jenis)
    {
        $this->jenis_presensi = $jenis;
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

        // Logika Waktu & Keterlambatan
        if ($jadwal) {
            $jamMasukJadwal = Carbon::parse($jadwal->shift->jam_masuk);
            $jamSekarang = Carbon::now();
            
            // Hitung Keterlambatan Normal
            if ($jamSekarang->gt($jamMasukJadwal->addMinutes(15))) {
                $status = 'Terlambat';
                $keterlambatan = $jamMasukJadwal->diffInMinutes($jamSekarang);
            }
        }

        // --- KOMPENSASI DINAS LUAR (Override Status) ---
        // Jika DL Awal/Penuh, abaikan keterlambatan masuk karena dianggap dinas sejak pagi
        if (in_array($this->jenis_presensi, ['DL Awal', 'DL Penuh'])) {
            $status = 'Hadir (Dinas)';
            $keterlambatan = 0;
        }

        // Logic Catatan
        $catatan = $this->keterangan_tambahan;
        if ($this->jenis_presensi == 'WFH') {
            $catatan = '[WFH] ' . $catatan;
        } elseif (str_contains($this->jenis_presensi, 'DL')) {
            $catatan = '[' . $this->jenis_presensi . '] ' . $catatan;
        }

        Presensi::create([
            'user_id' => Auth::id(),
            'jenis_presensi' => $this->jenis_presensi,
            'keterangan' => $catatan,
            'tanggal' => Carbon::today(),
            'jam_masuk' => Carbon::now(),
            'lokasi_masuk' => $lat . ',' . $lng,
            'status_kehadiran' => $status,
            'keterlambatan_menit' => $keterlambatan,
        ]);

        $this->dispatch('notify', 'success', 'Absen Masuk (' . $this->jenis_presensi . ') Berhasil!');
        $this->refreshData();
    }

    public function clockOut($lat, $lng)
    {
        if ($this->todayPresensi) {
            // Logika Kompensasi Pulang (Optional, biasanya jam pulang DL fleksibel)
            // Jika DL Akhir/Penuh, anggap pulang sesuai prosedur
            
            $this->todayPresensi->update([
                'jam_keluar' => Carbon::now(),
                'lokasi_keluar' => $lat . ',' . $lng,
            ]);
            
            $this->dispatch('notify', 'success', 'Absen Pulang Berhasil. Terima kasih!');
            $this->refreshData();
        }
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.index')
            ->layout('layouts.app', ['header' => 'Presensi Digital']);
    }
}