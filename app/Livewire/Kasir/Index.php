<?php

namespace App\Livewire\Kasir;

use App\Models\RekamMedis;
use App\Models\Antrean;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tab = 'belum_bayar'; // 'belum_bayar', 'lunas'

    public function setTab($tabName)
    {
        $this->tab = $tabName;
        $this->resetPage();
    }

    public function render()
    {
        $query = RekamMedis::with(['pasien', 'pembayaran'])
            ->whereHas('pasien', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            });

        if ($this->tab == 'belum_bayar') {
            // Logic: Rekam Medis selesai medis tapi belum lunas
            $query->whereDoesntHave('pembayaran', function($q) {
                $q->where('status', 'Lunas');
            })
            ->whereNotNull('diagnosa') // Pastikan sudah diperiksa dokter
            ->latest('tanggal_periksa');
        } else {
            // Logic: Sudah Lunas
            $query->whereHas('pembayaran', function($q) {
                $q->where('status', 'Lunas');
            })
            ->latest('tanggal_periksa');
        }

        return view('livewire.kasir.index', [
            'tagihan' => $query->paginate(10)
        ])->layout('layouts.app', ['header' => 'Billing & Kasir']);
    }
}