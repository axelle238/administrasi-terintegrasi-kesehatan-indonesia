<?php

namespace App\Livewire\Kepegawaian\Jadwal;

use Livewire\Component;
use App\Models\PertukaranJadwal;
use App\Models\JadwalJaga;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Swap extends Component
{
    public $step = 1;
    public $selectedJadwalAsal;
    public $selectedPengganti;
    public $selectedJadwalTujuan;
    public $alasan;

    public $jadwalSaya = [];
    public $users = [];
    public $jadwalTarget = [];

    public function mount()
    {
        // Ambil jadwal saya yg upcoming
        $pegawaiId = Auth::user()->pegawai->id ?? 0;
        $this->jadwalSaya = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', '>', Carbon::today())
            ->get();
            
        // Ambil list user lain (rekan kerja)
        $this->users = User::where('id', '!=', Auth::id())
            ->whereHas('pegawai')
            ->get();
    }

    public function selectJadwalAsal($id)
    {
        $this->selectedJadwalAsal = $id;
        $this->step = 2;
    }

    public function selectPengganti($id)
    {
        $this->selectedPengganti = $id;
        $pegawaiId = User::find($id)->pegawai->id ?? 0;
        
        $this->jadwalTarget = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', '>', Carbon::today())
            ->get();
            
        $this->step = 3;
    }

    public function selectJadwalTujuan($id)
    {
        $this->selectedJadwalTujuan = $id;
        $this->step = 4;
    }

    public function submit()
    {
        $this->validate([
            'alasan' => 'required|string|max:255'
        ]);

        PertukaranJadwal::create([
            'pemohon_id' => Auth::id(),
            'pengganti_id' => $this->selectedPengganti,
            'jadwal_asal_id' => $this->selectedJadwalAsal,
            'jadwal_tujuan_id' => $this->selectedJadwalTujuan,
            'alasan' => $this->alasan,
            'status' => 'Menunggu Respon'
        ]);

        $this->dispatch('notify', 'success', 'Permintaan tukar jadwal dikirim.');
        $this->reset(['step', 'selectedJadwalAsal', 'selectedPengganti', 'selectedJadwalTujuan', 'alasan']);
    }

    public function render()
    {
        $requests = PertukaranJadwal::where('pemohon_id', Auth::id())
            ->orWhere('pengganti_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.kepegawaian.jadwal.swap', [
            'requests' => $requests
        ])->layout('layouts.app', ['header' => 'Tukar Jadwal Jaga']);
    }
}