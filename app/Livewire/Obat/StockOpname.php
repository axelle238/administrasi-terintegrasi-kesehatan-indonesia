<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use App\Models\TransaksiObat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class StockOpname extends Component
{
    use WithPagination;

    public $search = '';
    public $adjustmentValues = []; // [obat_id => real_stock]
    public $notes = []; // [obat_id => reason]

    public function mount()
    {
        // Initialize logic if needed
    }

    public function adjust($obatId)
    {
        if (!isset($this->adjustmentValues[$obatId])) {
            $this->dispatch('notify', 'error', 'Masukkan jumlah stok nyata.');
            return;
        }

        $realStock = (int) $this->adjustmentValues[$obatId];
        $obat = Obat::find($obatId);
        
        if (!$obat) return;

        $currentSystemStock = $obat->stok;
        $diff = $realStock - $currentSystemStock;

        if ($diff == 0) {
            $this->dispatch('notify', 'info', 'Stok sudah sesuai.');
            return;
        }

        // Logic Adjustment
        // Create Transaction Record
        TransaksiObat::create([
            'obat_id' => $obatId,
            'jenis_transaksi' => $diff > 0 ? 'Masuk' : 'Keluar', // Penyesuaian
            'jumlah' => abs($diff),
            'tanggal_transaksi' => now(),
            'keterangan' => 'Stock Opname: ' . ($this->notes[$obatId] ?? 'Penyesuaian stok'),
            'pencatat' => Auth::user()->name ?? 'System'
        ]);

        $obat->update(['stok' => $realStock]);

        $this->dispatch('notify', 'success', 'Stok berhasil disesuaikan.');
        $this->reset(['adjustmentValues', 'notes']);
    }

    public function render()
    {
        $obats = Obat::where('nama_obat', 'like', '%' . $this->search . '%')
            ->orWhere('kode_obat', 'like', '%' . $this->search . '%')
            ->orderBy('nama_obat')
            ->paginate(10);

        return view('livewire.obat.stock-opname', [
            'obats' => $obats
        ])->layout('layouts.app', ['header' => 'Stock Opname Farmasi']);
    }
}