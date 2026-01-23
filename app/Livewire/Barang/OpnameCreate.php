<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\RiwayatBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OpnameCreate extends Component
{
    public $opnameId;
    public $tanggal;
    public $keterangan;
    
    public $items = [];
    public $physicalStocks = []; // [barang_id => quantity]
    public $itemNotes = []; // [barang_id => note]

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        // Load consumables (Barang Habis Pakai)
        $this->items = Barang::consumable()->get();
        
        foreach ($this->items as $item) {
            $this->physicalStocks[$item->id] = $item->stok; // Default to current stock
            $this->itemNotes[$item->id] = '';
        }
    }

    public function save($finalize = false)
    {
        $this->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'physicalStocks.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $opname = Opname::create([
                'tanggal' => $this->tanggal,
                'user_id' => auth()->id(),
                'keterangan' => $this->keterangan,
                'status' => $finalize ? 'Final' : 'Draft',
            ]);

            foreach ($this->items as $item) {
                $fisik = (int) $this->physicalStocks[$item->id];
                $sistem = $item->stok;
                $selisih = $fisik - $sistem;

                OpnameDetail::create([
                    'opname_id' => $opname->id,
                    'barang_id' => $item->id,
                    'stok_sistem' => $sistem,
                    'stok_fisik' => $fisik,
                    'selisih' => $selisih,
                    'keterangan' => $this->itemNotes[$item->id] ?? null,
                ]);

                if ($finalize && $selisih != 0) {
                    // Update Item Stock
                    $item->update(['stok' => $fisik]);

                    // Log History
                    RiwayatBarang::create([
                        'barang_id' => $item->id,
                        'user_id' => auth()->id(),
                        'jenis_transaksi' => $selisih > 0 ? 'Masuk' : 'Keluar',
                        'jumlah' => abs($selisih),
                        'stok_terakhir' => $fisik,
                        'tanggal' => $this->tanggal,
                        'keterangan' => "Opname Stok: " . ($this->itemNotes[$item->id] ?? 'Penyesuaian'),
                    ]);
                }
            }

            DB::commit();
            
            $this->dispatch('notify', 'success', $finalize ? 'Opname berhasil diselesaikan.' : 'Opname disimpan sebagai draft.');
            return redirect()->route('barang.opname.index');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.barang.opname-create')->layout('layouts.app', ['header' => 'Input Opname Stok']);
    }
}
