<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\MutasiBarang;
use App\Models\RiwayatBarang;
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
            // Default jumlah to 1 or max stock if low
            $this->jumlah = 1; 
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

        $barang = Barang::find($this->barang_id);

        if (!$barang) {
            $this->dispatch('notify', 'error', 'Barang tidak ditemukan.');
            return;
        }

        if ($this->jumlah > $barang->stok) {
            $this->dispatch('notify', 'error', 'Jumlah mutasi melebihi stok yang tersedia (' . $barang->stok . ').');
            return;
        }

        // If ruangan_id_asal is missing (legacy item), try to find it or just leave null
        // Ensure lokasi_tujuan string is set
        if (!$this->lokasi_tujuan && $this->ruangan_id_tujuan) {
             $r = Ruangan::find($this->ruangan_id_tujuan);
             $this->lokasi_tujuan = $r->nama_ruangan;
        }

        DB::transaction(function () use ($barang) {
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

            // 2. Handle Stock Logic
            if ($this->jumlah == $barang->stok) {
                // Move the entire item record
                $barang->update([
                    'ruangan_id' => $this->ruangan_id_tujuan,
                    'lokasi_penyimpanan' => $this->lokasi_tujuan
                ]);
            } else {
                // Split stock
                // Decrease source
                $barang->decrement('stok', $this->jumlah);
                
                // Create new item at destination
                $newItem = $barang->replicate();
                $newItem->stok = $this->jumlah;
                $newItem->ruangan_id = $this->ruangan_id_tujuan;
                $newItem->lokasi_penyimpanan = $this->lokasi_tujuan;
                $newItem->kode_barang = $barang->kode_barang; // Same code? Or append suffix? Usually same code allows aggregation.
                // Reset created_at/updated_at
                $newItem->created_at = now();
                $newItem->updated_at = now();
                $newItem->save();
            }

            // 3. Log Riwayat
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jenis_transaksi' => 'Mutasi Keluar',
                'jumlah' => $this->jumlah,
                'stok_terakhir' => $barang->stok, // Source stock after decrement (0 or partial)
                'tanggal' => $this->tanggal_mutasi,
                'keterangan' => 'Mutasi ke ' . $this->lokasi_tujuan
            ]);
            
            // Note: If we created a new item, strictly speaking we should log 'Mutasi Masuk' for that new ID?
            // But for simple audit, logging the source event is usually enough to trace where it went.
        });

        $this->dispatch('notify', 'success', 'Mutasi barang berhasil dicatat.');
        $this->isOpen = false;
        $this->reset(['barang_id', 'jumlah', 'keterangan']);
    }

    public function render()
    {
        return view('livewire.barang.mutasi', [
            'mutasis' => MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])->latest()->paginate(10),
            'barangs' => Barang::where('stok', '>', 0)->orderBy('nama_barang')->get(), // Only show items with stock
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
        ])->layout('layouts.app', ['header' => 'Mutasi & Distribusi Aset']);
    }
}