<?php

namespace App\Livewire\Masyarakat;

use App\Models\Pengaduan;
use Livewire\Component;
use Livewire\WithFileUploads;

class PengaduanPublic extends Component
{
    use WithFileUploads;

    public $nama_pelapor;
    public $email_pelapor;
    public $no_telepon_pelapor;
    public $subjek;
    public $isi_pengaduan;
    public $file_lampiran;

    protected $rules = [
        'nama_pelapor' => 'required|string|max:255',
        'email_pelapor' => 'nullable|email|max:255',
        'no_telepon_pelapor' => 'required|string|max:20',
        'subjek' => 'required|string|max:255',
        'isi_pengaduan' => 'required|string',
        'file_lampiran' => 'nullable|file|max:5120', // 5MB
    ];

    public function submit()
    {
        $this->validate();

        $path = null;
        if ($this->file_lampiran) {
            $path = $this->file_lampiran->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'nama_pelapor' => $this->nama_pelapor,
            'email_pelapor' => $this->email_pelapor,
            'no_telepon_pelapor' => $this->no_telepon_pelapor,
            'subjek' => $this->subjek,
            'isi_pengaduan' => $this->isi_pengaduan,
            'file_lampiran' => $path,
        ]);

        $this->reset();
        $this->dispatch('notify', 'success', 'Pengaduan Anda telah berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }

    public function render()
    {
        return view('livewire.masyarakat.pengaduan-public')->layout('layouts.guest');
    }
}
