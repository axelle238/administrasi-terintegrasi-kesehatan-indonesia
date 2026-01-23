<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\MutasiBarang;
use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Mutasi extends Component
{
    use WithPagination;

    public $barang_id;
    public $lokasi_asal; // String (Legacy/Display)
    public $lokasi_tujuan; // String (Legacy/Display)
    public $ruangan_id_asal;
    public $ruangan_id_tujuan;
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
        $this->reset(['barang_id', 'lokasi_asal', 'lokasi_tujuan', 'ruangan_id_asal', 'ruangan_id_tujuan', 'jumlah', 'keterangan']);
        $this->tanggal_mutasi = date('Y-m-d');
        $this->isOpen = true;
    }

    public function updatedBarangId($value)
    {
        $barang = Barang::with('ruangan')->find($value);
        if ($barang) {
            $this->ruangan_id_asal = $barang->ruangan_id;
            // Use Ruangan name if available, otherwise legacy string
            $this->lokasi_asal = $barang->ruangan ? $barang->ruangan->nama_ruangan : $barang->lokasi_penyimpanan;
        }
    }

    public function updatedRuanganIdTujuan($value)
    {
        $ruangan = Ruangan::find($value);
        if ($ruangan) {
            $this->lokasi_tujuan = $ruangan->nama_ruangan;
        }
    }

    public function save()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'ruangan_id_tujuan' => 'required|exists:ruangans,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_mutasi' => 'required|date',
        ]);

        // If ruangan_id_asal is missing (legacy item), try to find it or just leave null
        // Ensure lokasi_tujuan string is set
        if (!$this->lokasi_tujuan && $this->ruangan_id_tujuan) {
             $r = Ruangan::find($this->ruangan_id_tujuan);
             $this->lokasi_tujuan = $r->nama_ruangan;
        }

        DB::transaction(function () {
            // 1. Create Mutasi Record
            MutasiBarang::create([
                'barang_id' => $this->barang_id,
                'lokasi_asal' => $this->lokasi_asal ?: '-', // Fallback
                'lokasi_tujuan' => $this->lokasi_tujuan,
                'ruangan_id_asal' => $this->ruangan_id_asal,
                'ruangan_id_tujuan' => $this->ruangan_id_tujuan,
                'jumlah' => $this->jumlah,
                'tanggal_mutasi' => $this->tanggal_mutasi,
                'penanggung_jawab' => Auth::user()->name,
                'keterangan' => $this->keterangan
            ]);

            // 2. Update Barang Location (Master Data)
            $barang = Barang::find($this->barang_id);
            if ($barang) {
                // We update location regardless of 'is_asset' because even consumables move
                // But for consumables, usually we just track stock. 
                // However, the request implies tracking location.
                $barang->update([
                    'ruangan_id' => $this->ruangan_id_tujuan,
                    'lokasi_penyimpanan' => $this->lokasi_tujuan // Sync legacy string
                ]);
            }
        });

        $this->dispatch('notify', 'success', 'Mutasi barang berhasil dicatat.');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.barang.mutasi', [
            'mutasis' => MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])->latest()->paginate(10),
            'barangs' => Barang::orderBy('nama_barang')->get(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
        ])->layout('layouts.app', ['header' => 'Mutasi & Distribusi Aset']);
    }
}