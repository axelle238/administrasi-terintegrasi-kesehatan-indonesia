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

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

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