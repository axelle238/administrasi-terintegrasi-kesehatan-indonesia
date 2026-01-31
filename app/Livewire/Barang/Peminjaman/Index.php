<?php

namespace App\Livewire\Barang\Peminjaman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PeminjamanBarang;
use App\Models\Barang;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = ''; // 'Dipinjam', 'Dikembalikan'
    public $perPage = 10;

    // Form State
    public $isModalOpen = false;
    public $isReturnModalOpen = false;
    
    // Properties untuk Create
    public $barang_id, $pegawai_id, $tanggal_pinjam, $tanggal_kembali_rencana, $keterangan, $kondisi_keluar;
    
    // Properties untuk Return
    public $selectedPeminjamanId;
    public $tanggal_kembali_realisasi, $kondisi_kembali;

    public function mount()
    {
        $this->tanggal_pinjam = date('Y-m-d');
        $this->kondisi_keluar = 'Baik';
    }

    // === CREATE PEMINJAMAN ===
    public function create()
    {
        $this->reset(['barang_id', 'pegawai_id', 'tanggal_kembali_rencana', 'keterangan']);
        $this->tanggal_pinjam = date('Y-m-d');
        $this->kondisi_keluar = 'Baik';
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'pegawai_id' => 'required|exists:pegawais,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'kondisi_keluar' => 'required|string',
        ]);

        // Generate No Transaksi (Format: PINJ-Ymd-Random)
        $noTransaksi = 'PINJ-' . date('ymd') . '-' . strtoupper(substr(uniqid(), 0, 4));

        PeminjamanBarang::create([
            'no_transaksi' => $noTransaksi,
            'barang_id' => $this->barang_id,
            'pegawai_id' => $this->pegawai_id,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali_rencana' => $this->tanggal_kembali_rencana,
            'kondisi_keluar' => $this->kondisi_keluar,
            'status' => 'Dipinjam',
            'keterangan' => $this->keterangan,
            'user_id' => Auth::id(),
        ]);

        $this->isModalOpen = false;
        $this->dispatch('notify', type: 'success', message: 'Peminjaman berhasil dicatat.');
    }

    // === RETURN PEMINJAMAN (PENGEMBALIAN) ===
    public function openReturnModal($id)
    {
        $this->selectedPeminjamanId = $id;
        $this->tanggal_kembali_realisasi = date('Y-m-d');
        $this->kondisi_kembali = 'Baik';
        $this->isReturnModalOpen = true;
    }

    public function processReturn()
    {
        $this->validate([
            'tanggal_kembali_realisasi' => 'required|date',
            'kondisi_kembali' => 'required|string',
        ]);

        $peminjaman = PeminjamanBarang::findOrFail($this->selectedPeminjamanId);
        
        $peminjaman->update([
            'tanggal_kembali_realisasi' => $this->tanggal_kembali_realisasi,
            'kondisi_kembali' => $this->kondisi_kembali,
            'status' => 'Dikembalikan',
        ]);

        $this->isReturnModalOpen = false;
        $this->dispatch('notify', type: 'success', message: 'Barang telah dikembalikan.');
    }

    public function render()
    {
        $peminjaman = PeminjamanBarang::with(['barang', 'pegawai.user'])
            ->when($this->search, function($q) {
                $q->where('no_transaksi', 'like', '%'.$this->search.'%')
                  ->orWhereHas('barang', fn($b) => $b->where('nama_barang', 'like', '%'.$this->search.'%'))
                  ->orWhereHas('pegawai.user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        return view('livewire.barang.peminjaman.index', [
            'peminjaman' => $peminjaman,
            'barangs' => Barang::select('id', 'nama_barang', 'kode_barang')->orderBy('nama_barang')->get(),
            'pegawais' => Pegawai::with('user')->get(), // Asumsi relasi user ada untuk nama
        ])->layout('layouts.app', ['header' => 'Peminjaman Barang']);
    }
}