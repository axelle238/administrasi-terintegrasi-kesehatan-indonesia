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
    public $activeTab = 'sent'; // sent, received
    public $selectedJadwalAsal;
    public $selectedPengganti;
    public $selectedJadwalTujuan;
    public $alasan;

    public $jadwalSaya = [];
    public $users = [];
    public $jadwalTarget = [];

    public function mount()
    {
        $pegawaiId = Auth::user()->pegawai->id ?? 0;
        $this->jadwalSaya = JadwalJaga::with('shift')
            ->where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', '>', Carbon::today())
            ->get();
            
        $this->users = User::where('id', '!=', Auth::id())
            ->whereHas('pegawai')
            ->get();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
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
        $this->activeTab = 'sent';
    }

    public function approve($id)
    {
        $swap = PertukaranJadwal::where('pengganti_id', Auth::id())->findOrFail($id);
        
        if ($swap->status == 'Menunggu Respon') {
            // Update status
            $swap->update(['status' => 'Disetujui Rekan']);
            
            // Logic Opsional: Auto-swap jadwal di database (jika kebijakan membolehkan tanpa admin)
            // Atau biarkan Admin final approval. Kita asumsi Admin perlu approve final.
            
            $this->dispatch('notify', 'success', 'Permintaan disetujui. Menunggu konfirmasi Admin.');
        }
    }

    public function reject($id)
    {
        $swap = PertukaranJadwal::where('pengganti_id', Auth::id())->findOrFail($id);
        if ($swap->status == 'Menunggu Respon') {
            $swap->update(['status' => 'Ditolak']);
            $this->dispatch('notify', 'success', 'Permintaan ditolak.');
        }
    }

    public function render()
    {
        $sentRequests = PertukaranJadwal::where('pemohon_id', Auth::id())->latest()->get();
        $receivedRequests = PertukaranJadwal::where('pengganti_id', Auth::id())->latest()->get();

        return view('livewire.kepegawaian.jadwal.swap', [
            'sentRequests' => $sentRequests,
            'receivedRequests' => $receivedRequests
        ])->layout('layouts.app', ['header' => 'Tukar Jadwal Jaga']);
    }
}
