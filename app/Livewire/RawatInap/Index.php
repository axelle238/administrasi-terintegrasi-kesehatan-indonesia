<?php

namespace App\Livewire\RawatInap;

use App\Models\RawatInap;
use App\Models\Pasien;
use App\Models\Kamar;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $admissions = RawatInap::with(['pasien', 'kamar'])
            ->whereHas('pasien', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
            })
            ->latest('waktu_masuk')
            ->paginate(10);

        return view('livewire.rawat-inap.index', [
            'admissions' => $admissions,
        ])->layout('layouts.app', ['header' => 'Layanan Rawat Inap']);
    }
}
