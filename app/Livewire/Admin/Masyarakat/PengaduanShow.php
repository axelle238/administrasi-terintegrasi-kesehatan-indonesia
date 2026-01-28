<?php

namespace App\Livewire\Admin\Masyarakat;

use App\Models\Pengaduan;
use Livewire\Component;

class PengaduanShow extends Component
{
    public Pengaduan $pengaduan;
    public $tanggapan;
    public $status;

    public function mount(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
        $this->tanggapan = $pengaduan->tanggapan;
        $this->status = $pengaduan->status;
    }

    protected $rules = [
        'tanggapan' => 'required|string',
        'status' => 'required|in:Pending,Diproses,Selesai',
    ];

    public function update()
    {
        $this->validate();

        $this->pengaduan->update([
            'tanggapan' => $this->tanggapan,
            'status' => $this->status,
        ]);

        $this->dispatch('notify', 'success', 'Tanggapan pengaduan berhasil diperbarui.');
        return $this->redirect(route('admin.masyarakat.pengaduan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.masyarakat.pengaduan-show')->layout('layouts.app', ['header' => 'Detail & Tindak Lanjut Pengaduan']);
    }
}
