<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\MutasiBarang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Mutasi extends Component
{
    use WithPagination;

    public $barang_id;
    public $lokasi_asal;
    public $lokasi_tujuan;
    public $jumlah;
    public $tanggal_mutasi;
    public $keterangan;

    public $isOpen = false;

    public function mount()
    {
        $this->tanggal_mutasi = date('Y-m-d');
    }

    public function create()
    {
        $this->reset(['barang_id', 'lokasi_asal', 'lokasi_tujuan', 'jumlah', 'keterangan']);
        $this->tanggal_mutasi = date('Y-m-d');
        $this->isOpen = true;
    }

    public function updatedBarangId($value)
    {
        $barang = Barang::find($value);
        if ($barang) {
            $this->lokasi_asal = $barang->lokasi_penyimpanan; // Auto-fill current location
        }
    }

    public function save()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'lokasi_asal' => 'required|string',
            'lokasi_tujuan' => 'required|string',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_mutasi' => 'required|date',
        ]);

        DB::transaction(function () {
            // 1. Create Mutasi Record
            MutasiBarang::create([
                'barang_id' => $this->barang_id,
                'lokasi_asal' => $this->lokasi_asal,
                'lokasi_tujuan' => $this->lokasi_tujuan,
                'jumlah' => $this->jumlah,
                'tanggal_mutasi' => $this->tanggal_mutasi,
                'penanggung_jawab' => Auth::user()->name,
                'keterangan' => $this->keterangan
            ]);

            // 2. If it's an Asset (Aset Tetap), update its current location master data
            $barang = Barang::find($this->barang_id);
            if ($barang && $barang->is_asset) {
                $barang->update(['lokasi_penyimpanan' => $this->lokasi_tujuan]);
            }
        });

        $this->dispatch('notify', 'success', 'Mutasi barang berhasil dicatat.');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.barang.mutasi', [
            'mutasis' => MutasiBarang::with('barang')->latest()->paginate(10),
            'barangs' => Barang::orderBy('nama_barang')->get()
        ])->layout('layouts.app', ['header' => 'Mutasi & Distribusi Aset']);
    }
}