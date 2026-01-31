<?php

namespace App\Livewire\Barang;

use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\Barang;
use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpnameIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    
    // Form Create Opname
    public $tanggal;
    public $ruangan_id; // Opsional: Opname per ruangan
    public $keterangan;

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function create()
    {
        $this->reset(['ruangan_id', 'keterangan']);
        $this->tanggal = date('Y-m-d');
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'ruangan_id' => 'nullable|exists:ruangans,id',
        ]);

        DB::transaction(function () {
            // 1. Buat Header Opname
            $opname = Opname::create([
                'tanggal' => $this->tanggal,
                'user_id' => Auth::id(),
                'ruangan_id' => $this->ruangan_id,
                'keterangan' => $this->keterangan,
                'status' => 'Draft',
            ]);

            // 2. Snapshot Data Barang (Tarik semua barang atau per ruangan)
            // Asumsi: Saat ini stok barang masih global di tabel 'barangs'.
            // Jika ada filter ruangan, idealnya ambil barang di ruangan tsb (jika ada relasi pivot).
            // Untuk simplifikasi thd struktur database saat ini, kita tarik semua barang aktif.
            
            $barangs = Barang::all(); // TODO: Filter by ruangan if pivot exists

            foreach ($barangs as $barang) {
                OpnameDetail::create([
                    'opname_id' => $opname->id,
                    'barang_id' => $barang->id,
                    'stok_sistem' => $barang->stok,
                    'stok_fisik' => 0, // Default 0, user harus input nanti
                    'selisih' => 0 - $barang->stok,
                    'keterangan' => 'Inisialisasi Opname',
                ]);
            }
        });

        $this->isOpen = false;
        $this->dispatch('notify', 'success', 'Sesi stok opname berhasil dibuat. Silakan input hasil hitung.');
    }

    public function render()
    {
        $opnames = Opname::with(['user', 'ruangan'])
            ->latest('tanggal')
            ->paginate(10);

        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('livewire.barang.opname-index', [
            'opnames' => $opnames,
            'ruangans' => $ruangans
        ])->layout('layouts.app', ['header' => 'Stok Opname (Audit Aset)']);
    }
}
