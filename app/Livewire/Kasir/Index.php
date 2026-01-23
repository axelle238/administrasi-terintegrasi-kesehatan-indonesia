<?php

namespace App\Livewire\Kasir;

use App\Models\RekamMedis;
use App\Models\Antrean;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // Get patients who are ready for payment
        // Logic: Antrean status is 'Kasir' OR (Rekam Medis created today/recent AND not paid)
        
        $tagihan = RekamMedis::with(['pasien', 'pembayaran'])
            ->whereHas('pasien', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            })
            // Only show if not fully paid yet
            ->whereDoesntHave('pembayaran', function($q) {
                $q->where('status_pembayaran', 'Lunas');
            })
            // Ensure the medical process is actually done (at least Doctor has inspected)
            ->whereNotNull('diagnosa') 
            ->latest('tanggal_periksa')
            ->paginate(10);

        return view('livewire.kasir.index', [
            'tagihan' => $tagihan
        ])->layout('layouts.app', ['header' => 'Antrean Kasir & Pembayaran']);
    }
}
