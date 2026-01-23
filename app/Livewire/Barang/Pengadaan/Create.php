<?php

namespace App\Livewire\Barang\Pengadaan;

use App\Models\PengadaanBarang;
use App\Models\Barang;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $items = []; // [ ['barang_id' => '', 'jumlah' => 1, 'estimasi' => 0] ]
    public $keterangan;

    public function mount()
    {
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['barang_id' => '', 'jumlah_permintaan' => 1, 'estimasi_harga_satuan' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'items.*.barang_id' => 'required',
            'items.*.jumlah_permintaan' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $pengadaan = PengadaanBarang::create([
                'nomor_pengajuan' => 'REQ-' . date('YmdHis'),
                'tanggal_pengajuan' => now(),
                'pemohon_id' => Auth::id(),
                'status' => 'Pending',
                'keterangan' => $this->keterangan
            ]);

            foreach ($this->items as $item) {
                // Check if new or existing (for simplicity assuming existing from master)
                $barang = Barang::find($item['barang_id']);
                
                DB::table('pengadaan_barang_details')->insert([
                    'pengadaan_barang_id' => $pengadaan->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah_permintaan' => $item['jumlah_permintaan'],
                    'satuan' => $barang->satuan ?? 'Unit',
                    'estimasi_harga_satuan' => $item['estimasi_harga_satuan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            $this->dispatch('notify', 'success', 'Pengajuan berhasil dibuat.');
            return $this->redirect(route('barang.pengadaan.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.barang.pengadaan.create', [
            'barangs' => Barang::orderBy('nama_barang')->get()
        ])->layout('layouts.app', ['header' => 'Buat Pengajuan Barang']);
    }
}
