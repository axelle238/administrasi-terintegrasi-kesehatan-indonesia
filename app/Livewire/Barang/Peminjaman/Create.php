<?php

namespace App\Livewire\Barang\Peminjaman;

use Livewire\Component;
use App\Models\PeminjamanBarang;
use App\Models\Barang;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $barang_id;
    public $pegawai_id;
    public $tanggal_pinjam;
    public $tanggal_kembali_rencana;
    public $keterangan;
    public $kondisi_keluar = 'Baik';

    public function mount()
    {
        $this->tanggal_pinjam = date('Y-m-d');
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

        $this->dispatch('notify', 'success', 'Peminjaman berhasil dicatat.');
        return $this->redirect(route('barang.peminjaman.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.peminjaman.create', [
            'barangs' => Barang::orderBy('nama_barang')->get(),
            'pegawais' => Pegawai::with('user')->get(),
        ])->layout('layouts.app', ['header' => 'Catat Peminjaman Baru']);
    }
}
