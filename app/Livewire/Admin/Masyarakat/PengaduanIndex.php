<?php

namespace App\Livewire\Admin\Masyarakat;

use App\Models\Pengaduan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PengaduanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = ''; // '' = Semua, 'Menunggu', 'Diproses', 'Selesai'

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function setFilter($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function delete($id)
    {
        Pengaduan::findOrFail($id)->delete();
        $this->dispatch('notify', 'success', 'Pengaduan berhasil dihapus.');
    }

    public function render()
    {
        // 1. Statistik Ringkasan
        $stats = Pengaduan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
            
        $totalPengaduan = array_sum($stats);
        $pending = $stats['Menunggu'] ?? 0;
        $proses = $stats['Diproses'] ?? 0;
        $selesai = $stats['Selesai'] ?? 0;

        // 2. Query Data
        $query = Pengaduan::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_pelapor', 'like', '%' . $this->search . '%')
                  ->orWhere('subjek', 'like', '%' . $this->search . '%')
                  ->orWhere('no_telepon_pelapor', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $pengaduans = $query->latest()->paginate(10);

        return view('livewire.admin.masyarakat.pengaduan-index', compact(
            'pengaduans', 'totalPengaduan', 'pending', 'proses', 'selesai'
        ))->layout('layouts.app', ['header' => 'Manajemen Pengaduan & Aspirasi']);
    }
}
