<?php

namespace App\Livewire\Hrd\Lembur;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lembur;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = 'Menunggu';

    public function approve($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update(['status' => 'Disetujui', 'catatan_approval' => 'Disetujui Admin']);
        $this->dispatch('notify', 'success', 'Lembur disetujui.');
    }

    public function reject($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update(['status' => 'Ditolak', 'catatan_approval' => 'Ditolak Admin']);
        $this->dispatch('notify', 'success', 'Lembur ditolak.');
    }

    public function render()
    {
        $lemburs = Lembur::with(['user.pegawai'])
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.hrd.lembur.index', [
            'lemburs' => $lemburs
        ])->layout('layouts.app', ['header' => 'Persetujuan Lembur']);
    }
}
