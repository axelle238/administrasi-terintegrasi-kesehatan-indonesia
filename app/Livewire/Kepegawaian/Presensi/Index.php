<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Services\PresensiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $currentTime;
    public $todayPresensi;
    public $lokasi = null; 
    public $kategori = 'WFO'; // Default Mode Kerja

    public function mount()
    {
        $this->currentTime = Carbon::now()->translatedFormat('l, d F Y H:i');
        $this->todayPresensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();
            
        if ($this->todayPresensi) {
            $this->kategori = $this->todayPresensi->kategori;
        }
    }

    public function setKategori($tipe)
    {
        $this->kategori = $tipe;
    }

    public function absenMasuk(PresensiService $service)
    {
        $data = [
            'koordinat' => '-6.2088,106.8456', // Simulasi Geo
            'alamat' => $this->kategori == 'WFO' ? 'Kantor Pusat' : ($this->kategori == 'WFH' ? 'Rumah Pegawai' : 'Lokasi Dinas Luar'),
            'foto' => 'path/to/dummy_photo.jpg',
            'kategori' => $this->kategori // Kirim kategori yang dipilih user
        ];

        try {
            $service->absenMasuk(Auth::id(), $data);
            
            $msg = match($this->kategori) {
                'Dinas Luar' => 'Presensi Dinas Luar Berhasil! Laporan Aktivitas telah dibuat otomatis.',
                'WFH' => 'Presensi WFH Berhasil! Selamat bekerja.',
                default => 'Presensi Masuk Berhasil! Semangat bekerja.'
            };

            session()->flash('message', $msg);
            return redirect()->route('kepegawaian.presensi.history');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function absenKeluar(PresensiService $service)
    {
        $data = ['koordinat' => '-6.2088,106.8456', 'alamat' => 'Lokasi Terkini'];
        
        try {
            $service->absenKeluar(Auth::id(), $data);
            
            session()->flash('message', 'Presensi Pulang Berhasil. Terima kasih atas kerja keras Anda!');
            return redirect()->route('kepegawaian.presensi.history');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.index')
            ->layout('layouts.app', ['header' => 'Presensi Digital']);
    }
}