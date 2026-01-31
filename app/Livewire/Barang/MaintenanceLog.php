<?php

namespace App\Livewire\Barang;

use App\Models\Maintenance as MaintenanceModel;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceLog extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $maintenances = MaintenanceModel::with('barang')
            ->whereHas('barang', function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%');
            })
            ->latest('tanggal_maintenance')
            ->paginate(10);

        return view('livewire.barang.maintenance', [
            'maintenances' => $maintenances,
        ])->layout('layouts.app', ['header' => 'Log Pemeliharaan & Kalibrasi Aset']);
    }
}
