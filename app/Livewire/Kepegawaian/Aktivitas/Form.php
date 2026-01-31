<?php

namespace App\Livewire\Kepegawaian\Aktivitas;

use Livewire\Component;
use App\Models\LaporanHarian;
use App\Models\LaporanHarianDetail;
use App\Models\JadwalJaga;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $tanggal;
    public $kegiatanList = []; // Array of arrays: [jam_mulai, jam_selesai, kegiatan, output, progress]
    public $catatanHarian;
    public $shiftInfo;

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        $this->loadShiftInfo();
        
        // Inisialisasi 1 baris kosong
        $this->addKegiatan();
    }

    public function updatedTanggal()
    {
        $this->loadShiftInfo();
    }

    public function loadShiftInfo()
    {
        $jadwal = JadwalJaga::with('shift')
            ->where('user_id', Auth::id()) // Asumsi relasi user ada di jadwal, atau via pegawai
            ->whereDate('tanggal', $this->tanggal)
            ->first();
            
        // Fallback check via Pegawai relation if needed
        if(!$jadwal) {
            $pegawai = \App\Models\Pegawai::where('user_id', Auth::id())->first();
            if($pegawai) {
                $jadwal = JadwalJaga::with('shift')
                    ->where('pegawai_id', $pegawai->id)
                    ->whereDate('tanggal', $this->tanggal)
                    ->first();
            }
        }

        $this->shiftInfo = $jadwal ? $jadwal->shift->nama_shift . ' (' . $jadwal->shift->jam_masuk . ' - ' . $jadwal->shift->jam_keluar . ')' : 'Tidak ada jadwal shift';
    }

    public function addKegiatan()
    {
        $this->kegiatanList[] = [
            'jam_mulai' => Carbon::now()->format('H:i'),
            'jam_selesai' => Carbon::now()->addHour()->format('H:i'),
            'kegiatan' => '',
            'output' => '',
            'progress' => 100,
            'kategori' => 'Utama'
        ];
    }

    public function removeKegiatan($index)
    {
        unset($this->kegiatanList[$index]);
        $this->kegiatanList = array_values($this->kegiatanList); // Re-index array
    }

    public function save($status = 'Draft')
    {
        $this->validate([
            'tanggal' => 'required|date',
            'kegiatanList' => 'required|array|min:1',
            'kegiatanList.*.jam_mulai' => 'required',
            'kegiatanList.*.jam_selesai' => 'required',
            'kegiatanList.*.kegiatan' => 'required|string|min:5',
            'kegiatanList.*.output' => 'required|string',
            'kegiatanList.*.progress' => 'required|integer|min:0|max:100',
        ], [
            'kegiatanList.required' => 'Minimal harus ada satu kegiatan.',
            'kegiatanList.*.kegiatan.required' => 'Nama kegiatan wajib diisi.',
        ]);

        // Cek apakah sudah ada laporan di hari itu
        $laporan = LaporanHarian::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'tanggal' => $this->tanggal
            ],
            [
                'status' => $status,
                'catatan_harian' => $this->catatanHarian
            ]
        );

        // Update status jika existing
        $laporan->update([
            'status' => $status, 
            'catatan_harian' => $this->catatanHarian
        ]);

        // Hapus detail lama (Metode simplifikasi untuk update: delete all & re-insert)
        // Untuk sistem produksi yang lebih kompleks, bisa pakai updateOrInsert berdasarkan ID
        $laporan->details()->delete();

        foreach ($this->kegiatanList as $item) {
            $laporan->details()->create([
                'jam_mulai' => $item['jam_mulai'],
                'jam_selesai' => $item['jam_selesai'],
                'kegiatan' => $item['kegiatan'],
                'output' => $item['output'],
                'progress' => $item['progress'],
                'kategori' => $item['kategori'] ?? 'Utama',
            ]);
        }

        $msg = $status === 'Diajukan' ? 'Laporan berhasil dikirim ke atasan.' : 'Draft laporan berhasil disimpan.';
        session()->flash('message', $msg);
        
        return redirect()->route('aktivitas.index');
    }

    public function render()
    {
        return view('livewire.kepegawaian.aktivitas.form')
            ->layout('layouts.app', ['header' => 'Input Laporan Kinerja']);
    }
}