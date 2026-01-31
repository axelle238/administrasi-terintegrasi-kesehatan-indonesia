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
    public $kategoriInduk = 'WFO'; // Pilihan Utama: WFO, Dinas Luar, WFH
    public $subKategori = null; // Pilihan Detail: Awal, Akhir, Penuh

    public function mount()
    {
        $this->currentTime = Carbon::now()->translatedFormat('l, d F Y H:i');
        $this->todayPresensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();
            
        if ($this->todayPresensi) {
            $kat = $this->todayPresensi->kategori;
            if (str_contains($kat, 'Dinas Luar')) {
                $this->kategoriInduk = 'Dinas Luar';
                $this->subKategori = $kat; // Menyimpan string lengkap 'Dinas Luar Awal' dsb
            } else {
                $this->kategoriInduk = $kat;
            }
        }
    }

    public function setKategori($tipe)
    {
        $this->kategoriInduk = $tipe;
        $this->subKategori = null; // Reset sub jika ganti induk
        
        // Jika bukan Dinas Luar, subKategori langsung sama dengan induk untuk logika simpan
        if ($tipe !== 'Dinas Luar') {
            $this->subKategori = $tipe;
        }
    }

    public function setSubKategori($tipeLengkap)
    {
        $this->subKategori = $tipeLengkap;
    }

    public function absenMasuk(PresensiService $service)
    {
        // Validasi
        if ($this->kategoriInduk === 'Dinas Luar' && !$this->subKategori) {
            session()->flash('error', 'Silakan pilih jenis Dinas Luar terlebih dahulu.');
            return;
        }

        $kategoriFinal = $this->subKategori ?? $this->kategoriInduk;

        $data = [
            'koordinat' => '-6.2088,106.8456', 
            'alamat' => $kategoriFinal == 'WFO' ? 'Kantor Pusat' : ($kategoriFinal == 'WFH' ? 'Rumah Pegawai' : 'Lokasi Dinas Luar'),
            'foto' => 'path/to/dummy_photo.jpg',
            'kategori' => $kategoriFinal
        ];

        try {
            $service->absenMasuk(Auth::id(), $data);
            
            $msg = match($kategoriFinal) {
                'Dinas Luar Awal' => 'Presensi DL Awal (07:30 - 12:00) Berhasil.',
                'Dinas Luar Akhir' => 'Presensi DL Akhir (12:00 - 16:00) Berhasil.',
                'Dinas Luar Penuh' => 'Presensi DL Penuh (07:30 - 16:00) Berhasil.',
                'WFH' => 'Presensi WFH Berhasil.',
                default => 'Presensi Masuk Berhasil.'
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
            session()->flash('message', 'Presensi Pulang Berhasil.');
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