<?php

namespace App\Livewire\Kepegawaian\Jadwal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalJaga;
use App\Models\User;
use App\Models\PertukaranJadwal;
use Carbon\Carbon;

class Swap extends Component
{
    public $myScheduleId;
    public $targetUserId;
    public $targetScheduleId;
    public $alasan;

    public function mount()
    {
        // Initial setup if needed
    }

    public function save()
    {
        $this->validate([
            'myScheduleId' => 'required|exists:jadwal_jagas,id',
            'targetUserId' => 'required|exists:users,id|different:'.Auth::id(),
            'targetScheduleId' => 'required|exists:jadwal_jagas,id',
            'alasan' => 'required|string|max:255',
        ]);

        // Validasi Kepemilikan Jadwal
        $myJadwal = JadwalJaga::find($this->myScheduleId);
        if ($myJadwal->pegawai->user_id != Auth::id()) {
            $this->addError('myScheduleId', 'Jadwal ini bukan milik Anda.');
            return;
        }

        // Validasi Jadwal Target
        $targetJadwal = JadwalJaga::find($this->targetScheduleId);
        if ($targetJadwal->pegawai->user_id != $this->targetUserId) {
            $this->addError('targetScheduleId', 'Jadwal target tidak sesuai dengan pegawai yang dipilih.');
            return;
        }

        PertukaranJadwal::create([
            'pemohon_id' => Auth::id(),
            'jadwal_pemohon_id' => $this->myScheduleId,
            'pengganti_id' => $this->targetUserId,
            'jadwal_pengganti_id' => $this->targetScheduleId,
            'alasan' => $this->alasan,
            'status' => 'Menunggu Persetujuan Rekan'
        ]);

        $this->dispatch('notify', 'success', 'Permintaan tukar jadwal berhasil dikirim.');
        $this->reset(['myScheduleId', 'targetUserId', 'targetScheduleId', 'alasan']);
    }

    public function approveRequest($id)
    {
        $swap = PertukaranJadwal::find($id);
        
        // Cek jika user adalah pihak pengganti
        if ($swap->pengganti_id == Auth::id() && $swap->status == 'Menunggu Persetujuan Rekan') {
            $swap->update(['status' => 'Menunggu Approval Admin']);
            $this->dispatch('notify', 'success', 'Anda menyetujui pertukaran. Menunggu Admin.');
        }
    }

    public function rejectRequest($id)
    {
        $swap = PertukaranJadwal::find($id);
        if ($swap->pengganti_id == Auth::id() || $swap->pemohon_id == Auth::id()) {
            $swap->update(['status' => 'Ditolak']);
            $this->dispatch('notify', 'info', 'Pertukaran dibatalkan/ditolak.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        // Jadwal Saya (Aktif, belum lewat)
        $mySchedules = [];
        if ($pegawai) {
            $mySchedules = JadwalJaga::where('pegawai_id', $pegawai->id)
                ->whereDate('tanggal', '>=', Carbon::today())
                ->get();
        }

        // Potential Targets (Rekan satu poli/jabatan)
        $potentialTargets = User::whereHas('pegawai', function($q) use ($pegawai) {
            if ($pegawai) {
                $q->where('poli_id', $pegawai->poli_id)
                  ->where('id', '!=', $pegawai->id);
            }
        })->get();

        // Target Schedules (Reactive based on selected user)
        $targetSchedules = [];
        if ($this->targetUserId) {
            $targetPegawai = \App\Models\Pegawai::where('user_id', $this->targetUserId)->first();
            if ($targetPegawai) {
                $targetSchedules = JadwalJaga::where('pegawai_id', $targetPegawai->id)
                    ->whereDate('tanggal', '>=', Carbon::today())
                    ->get();
            }
        }

        // List Permintaan (Masuk & Keluar)
        $incomingRequests = PertukaranJadwal::where('pengganti_id', $user->id)
            ->where('status', 'Menunggu Persetujuan Rekan')
            ->get();
            
        $myRequests = PertukaranJadwal::where('pemohon_id', $user->id)
            ->latest()
            ->get();

        return view('livewire.kepegawaian.jadwal.swap', [
            'mySchedules' => $mySchedules,
            'potentialTargets' => $potentialTargets,
            'targetSchedules' => $targetSchedules,
            'incomingRequests' => $incomingRequests,
            'myRequests' => $myRequests
        ])->layout('layouts.app', ['header' => 'Tukar Jadwal Dinas']);
    }
}
