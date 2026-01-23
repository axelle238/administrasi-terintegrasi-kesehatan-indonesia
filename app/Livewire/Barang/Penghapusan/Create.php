<?php

namespace App\Livewire\Barang\Penghapusan;

use App\Models\Barang;
use App\Models\PenghapusanBarang;
use App\Models\PenghapusanBarangDetail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $keterangan;
    public $items = [];

    public function mount()
    {
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'barang_id' => '',
            'jumlah' => 1,
            'kondisi_terakhir' => 'Rusak Berat',
            'alasan' => '',
            'nilai_buku' => 0
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 3 && $parts[2] === 'barang_id') {
            $index = $parts[1];
            $barang = Barang::find($value);
            if ($barang) {
                $this->items[$index]['nilai_buku'] = $barang->nilai_buku;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.kondisi_terakhir' => 'required|string',
            'items.*.alasan' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $penghapusan = PenghapusanBarang::create([
                'nomor_dokumen' => 'WO-' . date('YmdHis'),
                'tanggal_pengajuan' => now(),
                'diajukan_oleh' => Auth::id(),
                'status' => 'Pending',
                'keterangan' => $this->keterangan
            ]);

            foreach ($this->items as $item) {
                PenghapusanBarangDetail::create([
                    'penghapusan_barang_id' => $penghapusan->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'kondisi_terakhir' => $item['kondisi_terakhir'],
                    'nilai_buku_saat_ini' => $item['nilai_buku'] ?? 0,
                    'alasan' => $item['alasan']
                ]);
            }

            DB::commit();
            $this->dispatch('notify', 'success', 'Usulan penghapusan berhasil dibuat.');
            return redirect()->route('barang.penghapusan.index');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.barang.penghapusan.create', [
            'barangs' => Barang::orderBy('nama_barang')->get()
        ])->layout('layouts.app', ['header' => 'Buat Usulan Penghapusan']);
    }
}
