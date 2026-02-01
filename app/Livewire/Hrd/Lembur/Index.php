<?php

namespace App\Livewire\Hrd\Lembur;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lembur;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = 'Pending';

    public function approve($id)
    {
        $lembur = Lembur::find($id);
        if($lembur && $lembur->status == 'Pending') {
            $lembur->update(['status' => 'Disetujui']);
            session()->flash('message', 'Lembur disetujui.');
        }
    }

    public function reject($id)
    {
        $lembur = Lembur::find($id);
        if($lembur && $lembur->status == 'Pending') {
            $lembur->update(['status' => 'Ditolak']);
            session()->flash('message', 'Lembur ditolak.');
        }
    }

    public function render()
    {
        $data = Lembur::with(['user.pegawai'])
            ->when($this->filterStatus, function($q) {
                return $q->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.hrd.lembur.index', [
            'data' => $data
        ])->layout('layouts.app', ['header' => 'Verifikasi Lembur']);
    }
}