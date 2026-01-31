<?php

namespace App\Livewire\Antrean;

use App\Models\Pasien;
use App\Models\Poli;
use App\Services\AntreanService;
use App\Services\BpjsBridgingService;
use App\Services\NotifikasiService;
use Carbon\Carbon;
use Livewire\Component;

class Kiosk extends Component
{
    // State Halaman (Wizard)
    public $tahap = 1; // 1: Input Identitas, 2: Konfirmasi Pasien, 3: Pilih Poli, 4: Cetak Tiket
    
    // Data Input
    public $identitas; // NIK atau No. BPJS
    public $metodeBayar = 'Umum'; // Umum / BPJS
    
    // Data Model
    public $pasien;
    public $daftarPoli;
    public $poliTerpilih;
    public $tiketAntrean;
    
    // Pesan UI
    public $pesanError = '';

    public function mount()
    {
        // Ambil hanya poli yang buka (logic sederhana dulu)
        $this->daftarPoli = Poli::where('status_aktif', true)->get();
    }

    // Tahap 1 -> 2: Cek Data Pasien
    public function cekPasien(BpjsBridgingService $bpjs)
    {
        $this->resetErrorBag();
        $this->pesanError = '';

        $this->validate([
            'identitas' => 'required|numeric|digits_between:10,16'
        ], [
            'identitas.required' => 'Mohon masukkan NIK atau Nomor Kartu BPJS Anda.',
            'identitas.numeric' => 'Format nomor tidak valid, hanya angka diperbolehkan.',
            'identitas.digits_between' => 'Panjang nomor harus antara 10 sampai 16 digit.'
        ]);

        // 1. Cari di Database Lokal
        $this->pasien = Pasien::where('nik', $this->identitas)
            ->orWhere('no_bpjs', $this->identitas)
            ->first();

        // 2. Jika tidak ada, coba Bridging BPJS (Auto-Register)
        if (!$this->pasien) {
            try {
                $res = $bpjs->getPeserta($this->identitas);
                
                if ($res['status'] == 'success') {
                    $data = $res['data'];
                    // Auto Register
                    $this->pasien = Pasien::create([
                        'nik' => $data['nik'],
                        'no_bpjs' => $data['noKartu'],
                        'nama_lengkap' => $data['nama'],
                        'tanggal_lahir' => $data['tglLahir'],
                        'jenis_kelamin' => $data['sex'] == 'L' ? 'Laki-laki' : 'Perempuan',
                        'alamat' => 'Alamat sesuai KTP (Data BPJS)', 
                        'no_telepon' => '-', 
                        'asuransi' => 'BPJS',
                        'faskes_asal' => $data['provUmum']['nmProvider'] ?? '-'
                    ]);
                    
                    // Simpan Log Notifikasi ke Admin bahwa ada pasien baru auto-register
                    NotifikasiService::sendToAdmin(
                        'Pendaftaran Pasien Baru (Kiosk)', 
                        'Pasien baru a.n ' . $this->pasien->nama_lengkap . ' terdaftar otomatis via Kiosk.',
                        route('pasien.show', $this->pasien->id)
                    );

                } else {
                    // Jika gagal bridging
                    $this->pesanError = 'Data tidak ditemukan. Silakan menuju Loket Pendaftaran Manual untuk bantuan petugas.';
                    return;
                }
            } catch (\Exception $e) {
                // Fallback jika koneksi error
                $this->pesanError = 'Terjadi gangguan koneksi. Mohon menuju Loket Pendaftaran.';
                return;
            }
        }

        // 3. Validasi Antrean Ganda (Hari Ini)
        $sudahDaftar = \App\Models\Antrean::where('pasien_id', $this->pasien->id)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->exists();

        if ($sudahDaftar) {
            $this->pesanError = 'Anda sudah mengambil antrean hari ini. Silakan cek riwayat atau hubungi petugas.';
            return;
        }

        // Sukses, lanjut konfirmasi
        $this->tahap = 2;
    }

    // Tahap 2 -> 3: Konfirmasi Data & Pilih Poli
    public function konfirmasiPasien()
    {
        $this->tahap = 3;
    }

    public function pilihPoli($poliId, AntreanService $antreanService)
    {
        $this->poliTerpilih = Poli::find($poliId);
        
        if (!$this->poliTerpilih) {
            $this->pesanError = 'Poli tidak valid.';
            return;
        }

        // Generate Tiket
        $this->tiketAntrean = $antreanService->buatAntrean(
            $this->pasien->id, 
            $this->poliTerpilih->id, 
            'kiosk'
        );

        $this->tahap = 4;
    }

    public function resetKiosk()
    {
        $this->reset(['tahap', 'identitas', 'pasien', 'poliTerpilih', 'tiketAntrean', 'pesanError']);
    }

    public function render()
    {
        return view('livewire.antrean.kiosk')->layout('layouts.guest');
    }
}