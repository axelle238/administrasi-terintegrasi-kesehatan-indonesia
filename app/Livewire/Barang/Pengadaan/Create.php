<?php

namespace App\Livewire\Barang\Pengadaan;

use App\Models\PengadaanBarang;
use App\Models\Barang;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $supplier_id;
    public $keterangan;
    public $items = []; // [ ['type' => 'existing', 'barang_id' => '', 'nama_barang' => '', 'jumlah_permintaan' => 1, 'satuan' => '', 'estimasi_harga_satuan' => 0] ]

    public function mount()
    {
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'key' => uniqid(),
            'type' => 'existing', // existing | new
            'barang_id' => '',
            'nama_barang' => '', // For new items
            'jumlah_permintaan' => 1,
            'satuan' => 'Unit', // Default, editable for new items
            'estimasi_harga_satuan' => 0
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        // Auto-fill satuan if existing barang selected
        $parts = explode('.', $key);
        if (count($parts) === 3 && $parts[2] === 'barang_id') {
            $index = $parts[1];
            if ($this->items[$index]['type'] === 'existing' && !empty($value)) {
                $barang = Barang::find($value);
                if ($barang) {
                    $this->items[$index]['satuan'] = $barang->satuan;
                    $this->items[$index]['nama_barang'] = $barang->nama_barang; // Fallback name
                }
            }
        }
    }

    public function save()
    {
        $this->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'items.*.type' => 'required|in:existing,new',
            'items.*.barang_id' => 'required_if:items.*.type,existing',
            'items.*.nama_barang' => 'required_if:items.*.type,new',
            'items.*.jumlah_permintaan' => 'required|numeric|min:1',
            'items.*.satuan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $pengadaan = PengadaanBarang::create([
                'nomor_pengajuan' => 'REQ-' . date('YmdHis'),
                'tanggal_pengajuan' => now(),
                'pemohon_id' => Auth::id(),
                'supplier_id' => $this->supplier_id,
                'status' => 'Pending',
                'keterangan' => $this->keterangan
            ]);

            foreach ($this->items as $item) {
                DB::table('pengadaan_barang_details')->insert([
                    'pengadaan_barang_id' => $pengadaan->id,
                    'barang_id' => $item['type'] === 'existing' ? $item['barang_id'] : null,
                    'nama_barang_baru' => $item['type'] === 'existing' 
                        ? (Barang::find($item['barang_id'])->nama_barang ?? '-') 
                        : $item['nama_barang'],
                    'jumlah_minta' => $item['jumlah_permintaan'],
                    'jumlah_disetujui' => 0, // Default
                    'satuan' => $item['satuan'],
                    'harga_satuan_estimasi' => $item['estimasi_harga_satuan'],
                    'total_harga' => $item['jumlah_permintaan'] * $item['estimasi_harga_satuan'],
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
            'barangs' => Barang::orderBy('nama_barang')->get(),
            'suppliers' => Supplier::orderBy('nama_supplier')->get(),
        ])->layout('layouts.app', ['header' => 'Buat Pengajuan Barang']);
    }
}
