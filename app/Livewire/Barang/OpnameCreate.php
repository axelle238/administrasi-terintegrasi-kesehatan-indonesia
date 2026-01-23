<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\RiwayatBarang;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OpnameCreate extends Component
{
    public $opnameId;
    public $tanggal;
    public $keterangan;
    public $ruangan_id;
    
    public $items = [];
    public $physicalStocks = []; // [barang_id => quantity]
    public $itemNotes = []; // [barang_id => note]

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->loadItems();
    }

    public function updatedRuanganId()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $query = Barang::query();
        
        // Filter by Ruangan if selected
        if ($this->ruangan_id) {
            $query->where('ruangan_id', $this->ruangan_id);
        } else {
            // If no room selected, maybe just load consumables or those without room?
            // Or default to all? Let's default to all but limit to consumables if desired.
            // But assets are also opname-able. Let's include everything or just consumables.
            // Usually opname is for everything.
            // Let's keep it broad but maybe order by room.
        }

        $this->items = $query->orderBy('nama_barang')->get();
        
        // Reset stocks array to avoid stale data
        $this->physicalStocks = [];
        $this->itemNotes = [];

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
            'ruangan_id' => 'nullable|exists:ruangans,id',
        ]);

        DB::beginTransaction();
        try {
            $opname = Opname::create([
                'tanggal' => $this->tanggal,
                'user_id' => auth()->id(),
                'ruangan_id' => $this->ruangan_id,
                'keterangan' => $this->keterangan,
                'status' => $finalize ? 'Final' : 'Draft',
            ]);

            foreach ($this->items as $item) {
                // Only process items that are in the list (in case of tampering)
                if (!isset($this->physicalStocks[$item->id])) continue;

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
        return view('livewire.barang.opname-create', [
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get()
        ])->layout('layouts.app', ['header' => 'Input Opname Stok']);
    }
}
