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
    public Opname $opname;
    
    // Properties for View
    public $tanggal;
    public $keterangan;
    public $ruangan_id;
    
    public $items = [];
    public $physicalStocks = []; // [detail_id => quantity]
    public $itemNotes = []; // [detail_id => note]

    public function mount(Opname $opname)
    {
        $this->opname = $opname->load('details.barang', 'ruangan');
        
        $this->tanggal = $opname->tanggal;
        $this->keterangan = $opname->keterangan;
        $this->ruangan_id = $opname->ruangan_id;

        $this->loadItems();
    }

    public function loadItems()
    {
        // Load from existing details
        $this->items = $this->opname->details;
        
        // Initialize input fields
        foreach ($this->items as $detail) {
            $this->physicalStocks[$detail->id] = $detail->stok_fisik; 
            $this->itemNotes[$detail->id] = $detail->keterangan;
        }
    }

    public function save($finalize = false)
    {
        if ($this->opname->status == 'Final') {
            $this->dispatch('notify', 'error', 'Opname sudah final dan tidak dapat diubah.');
            return;
        }

        $this->validate([
            'physicalStocks.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Update Header (Optional updates)
            $this->opname->update([
                'keterangan' => $this->keterangan,
                'status' => $finalize ? 'Final' : 'Draft',
            ]);

            foreach ($this->items as $detail) {
                // Skip if somehow input is missing
                if (!isset($this->physicalStocks[$detail->id])) continue;

                $fisik = (int) $this->physicalStocks[$detail->id];
                $sistem = $detail->stok_sistem; // Keep original snapshot
                $selisih = $fisik - $sistem;

                // Update Detail
                $detail->update([
                    'stok_fisik' => $fisik,
                    'selisih' => $selisih,
                    'keterangan' => $this->itemNotes[$detail->id] ?? null,
                ]);

                // Finalize Logic
                if ($finalize && $selisih != 0) {
                    $barang = $detail->barang;
                    if ($barang) {
                        // Update Master Stock
                        $barang->update(['stok' => $fisik]);

                        // Log History
                        RiwayatBarang::create([
                            'barang_id' => $barang->id,
                            'user_id' => auth()->id(),
                            'jenis_transaksi' => $selisih > 0 ? 'Masuk' : 'Keluar',
                            'jumlah' => abs($selisih),
                            'stok_terakhir' => $fisik,
                            'tanggal' => now(), // Use execution time for log
                            'keterangan' => "Opname Stok (Adj): " . ($this->itemNotes[$detail->id] ?? 'Penyesuaian Audit'),
                        ]);
                    }
                }
            }

            DB::commit();
            
            $this->dispatch('notify', 'success', $finalize ? 'Opname berhasil diselesaikan.' : 'Progress disimpan.');
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
