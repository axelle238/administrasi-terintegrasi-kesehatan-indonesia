<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Artisan;

class Penyusutan extends Component
{
    use WithPagination;

    public $search = '';

    public function recalculate()
    {
        try {
            Artisan::call('asset:calculate-depreciation');
            $this->dispatch('notify', 'success', 'Nilai buku aset berhasil diperbarui.');
        } catch (\Exception $e) {
            $this->dispatch('notify', 'error', 'Gagal menghitung penyusutan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $assets = Barang::where('is_asset', true)
            ->where(function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_barang')
            ->paginate(10);

        return view('livewire.barang.penyusutan', [
            'assets' => $assets
        ])->layout('layouts.app', ['header' => 'Penyusutan Aset (Depresiasi)']);
    }
}
