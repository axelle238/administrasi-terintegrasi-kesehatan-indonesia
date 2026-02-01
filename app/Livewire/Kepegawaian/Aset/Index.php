<?php

namespace App\Livewire\Kepegawaian\Aset;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AsetPegawai;
use App\Models\Pegawai;
use App\Models\Barang;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'Dipakai';

    // Form State
    public $isHandoverOpen = false;
    
    // Handover Form
    public $pegawai_id;
    public $barang_id;
    public $tanggal_terima;
    public $kondisi_saat_terima = 'Baik';
    public $keterangan;

    // Return Form
    public $returnId;
    public $tanggal_kembali;
    public $kondisi_saat_kembali = 'Baik';

    public function render()
    {
        $asets = AsetPegawai::with(['pegawai.user', 'barang'])
            ->where('status', $this->filterStatus)
            ->when($this->search, function($q) {
                $q->whereHas('pegawai.user', function($sq) {
                    $sq->where('name', 'like', '%'.$this->search.'%');
                })->orWhereHas('barang', function($sq) {
                    $sq->where('nama_barang', 'like', '%'.$this->search.'%');
                });
            })
            ->latest('tanggal_terima')
            ->paginate(10);

        return view('livewire.kepegawaian.aset.index', [
            'asets' => $asets,
            'pegawais' => Pegawai::with('user')->get(),
            'barangs' => Barang::where('is_asset', true)->where('stok', '>', 0)->get(), // Hanya barang yang ada stok
        ])->layout('layouts.app', ['header' => 'Inventaris & Fasilitas Pegawai']);
    }

    public function openHandover()
    {
        $this->resetForm();
        $this->isHandoverOpen = true;
    }

    public function saveHandover()
    {
        $this->validate([
            'pegawai_id' => 'required',
            'barang_id' => 'required',
            'tanggal_terima' => 'required|date',
        ]);

        $barang = Barang::find($this->barang_id);
        
        if ($barang->stok <= 0) {
            $this->addError('barang_id', 'Stok barang ini habis.');
            return;
        }

        AsetPegawai::create([
            'pegawai_id' => $this->pegawai_id,
            'barang_id' => $this->barang_id,
            'tanggal_terima' => $this->tanggal_terima,
            'kondisi_saat_terima' => $this->kondisi_saat_terima,
            'keterangan' => $this->keterangan,
            'status' => 'Dipakai'
        ]);

        // Kurangi Stok Master
        $barang->decrement('stok');

        $this->isHandoverOpen = false;
        $this->resetForm();
        $this->dispatch('notify', 'success', 'Serah terima aset berhasil dicatat.');
    }

    public function processReturn($id)
    {
        // Simple return logic (bisa dikembangkan jadi form inline juga)
        $aset = AsetPegawai::findOrFail($id);
        
        $aset->update([
            'tanggal_kembali' => Carbon::now(),
            'kondisi_saat_kembali' => 'Baik', // Default, idealnya input user
            'status' => 'Dikembalikan'
        ]);

        // Kembalikan Stok
        $aset->barang->increment('stok');

        $this->dispatch('notify', 'success', 'Aset telah dikembalikan.');
    }

    public function cancel()
    {
        $this->isHandoverOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['pegawai_id', 'barang_id', 'tanggal_terima', 'kondisi_saat_terima', 'keterangan']);
    }
}