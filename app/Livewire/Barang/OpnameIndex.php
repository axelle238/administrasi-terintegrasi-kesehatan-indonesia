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
    public $scope = 'all'; // all, medis, umum
    public $keterangan;

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function openForm()
    {
        $this->reset(['ruangan_id', 'keterangan', 'scope']);
        $this->tanggal = date('Y-m-d');
        $this->isOpen = true;
    }

    public function closeForm()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'scope' => 'required|in:all,medis,umum',
        ]);

        DB::transaction(function () {
            // 1. Buat Header Opname
            $note = "Scope: " . ucfirst($this->scope) . ". " . $this->keterangan;
            
            $opname = Opname::create([
                'tanggal' => $this->tanggal,
                'user_id' => Auth::id(),
                'ruangan_id' => $this->ruangan_id,
                'keterangan' => $note,
                'status' => 'Draft',
            ]);

            // 2. Snapshot Data Barang
            $query = Barang::query();

            // Filter by Ruangan
            if ($this->ruangan_id) {
                $query->where('ruangan_id', $this->ruangan_id);
            }

            // Filter by Scope (Medical vs General)
            if ($this->scope == 'medis') {
                $query->where(function($q) {
                    $q->where('jenis_aset', 'Medis')
                      ->orWhereHas('kategori', function($sq) {
                          $sq->where('nama_kategori', 'like', '%Medis%')
                            ->orWhere('nama_kategori', 'like', '%Kesehatan%')
                            ->orWhere('nama_kategori', 'like', '%Alat%');
                      });
                });
            } elseif ($this->scope == 'umum') {
                $query->where(function($q) {
                    $q->where('jenis_aset', '!=', 'Medis')
                      ->orWhere(function($subQ) {
                          $subQ->whereNull('jenis_aset')
                               ->whereHas('kategori', function($sq) {
                                   $sq->where('nama_kategori', 'not like', '%Medis%')
                                      ->where('nama_kategori', 'not like', '%Kesehatan%')
                                      ->where('nama_kategori', 'not like', '%Alat%');
                               });
                      });
                });
            }

            $barangs = $query->get();

            foreach ($barangs as $barang) {
                OpnameDetail::create([
                    'opname_id' => $opname->id,
                    'barang_id' => $barang->id,
                    'stok_sistem' => $barang->stok,
                    'stok_fisik' => 0, // Default 0
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
