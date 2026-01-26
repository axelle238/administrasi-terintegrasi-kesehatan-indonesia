<?php

namespace App\Livewire\Admin\Masyarakat;

use App\Models\Pengaduan;
use Livewire\Component;
use Livewire\WithPagination;

class PengaduanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    
    // Reply form
    public $selectedId;
    public $tanggapan;
    public $newStatus;
    public $isReplying = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function selectForReply($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $this->selectedId = $id;
        $this->tanggapan = $pengaduan->tanggapan;
        $this->newStatus = $pengaduan->status;
        $this->isReplying = true;
    }

    public function cancelReply()
    {
        $this->reset(['selectedId', 'tanggapan', 'newStatus', 'isReplying']);
    }

    public function saveReply()
    {
        $this->validate([
            'tanggapan' => 'required|string',
            'newStatus' => 'required|in:Pending,Diproses,Selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($this->selectedId);
        $pengaduan->update([
            'tanggapan' => $this->tanggapan,
            'status' => $this->newStatus,
        ]);

        $this->cancelReply();
        $this->dispatch('notify', 'success', 'Tanggapan berhasil disimpan.');
    }

    public function delete($id)
    {
        Pengaduan::findOrFail($id)->delete();
        $this->dispatch('notify', 'success', 'Pengaduan berhasil dihapus.');
    }

    public function render()
    {
        $query = Pengaduan::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_pelapor', 'like', '%' . $this->search . '%')
                  ->orWhere('subjek', 'like', '%' . $this->search . '%')
                  ->orWhere('isi_pengaduan', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $pengaduans = $query->latest()->paginate(10);

        return view('livewire.admin.masyarakat.pengaduan-index', [
            'pengaduans' => $pengaduans
        ])->layout('layouts.app', ['header' => 'Kelola Pengaduan Masyarakat']);
    }
}
