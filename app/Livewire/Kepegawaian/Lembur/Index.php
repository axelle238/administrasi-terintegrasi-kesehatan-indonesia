<?php

namespace App\Livewire\Kepegawaian\Lembur;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithFileUploads;

    public $tanggal;
    public $jam_mulai;
    public $jam_selesai;
    public $alasan_lembur;
    public $output_kerja;
    public $bukti_lembur;
    
    public $isOpen = false;

    public function create()
    {
        $this->reset(['tanggal', 'jam_mulai', 'jam_selesai', 'alasan_lembur', 'output_kerja', 'bukti_lembur']);
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'alasan_lembur' => 'required|string',
            'output_kerja' => 'required|string',
            'bukti_lembur' => 'nullable|image|max:2048', // Opsional saat pengajuan
        ]);

        $path = null;
        if ($this->bukti_lembur) {
            $path = $this->bukti_lembur->store('bukti-lembur', 'public');
        }

        Lembur::create([
            'user_id' => Auth::id(),
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'alasan_lembur' => $this->alasan_lembur,
            'output_kerja' => $this->output_kerja,
            'bukti_lembur' => $path,
            'status' => 'Menunggu'
        ]);

        $this->dispatch('notify', 'success', 'Pengajuan lembur dikirim.');
        $this->isOpen = false;
        $this->reset(['tanggal', 'jam_mulai', 'jam_selesai', 'alasan_lembur', 'output_kerja', 'bukti_lembur']);
    }

    public function cancel($id)
    {
        $lembur = Lembur::where('user_id', Auth::id())->find($id);
        if ($lembur && $lembur->status == 'Menunggu') {
            $lembur->delete();
            $this->dispatch('notify', 'success', 'Pengajuan dibatalkan.');
        }
    }

    public function render()
    {
        $lemburs = Lembur::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.kepegawaian.lembur.index', [
            'lemburs' => $lemburs
        ])->layout('layouts.app', ['header' => 'Pengajuan Lembur (Overtime)']);
    }
}