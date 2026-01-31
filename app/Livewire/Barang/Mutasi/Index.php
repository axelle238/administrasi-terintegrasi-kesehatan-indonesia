<?php

namespace App\Livewire\Barang\Mutasi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MutasiBarang;
use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    // Form Properties
    public $isModalOpen = false;
    public $barang_id, $ruangan_id_asal, $ruangan_id_tujuan, $jumlah, $tanggal_mutasi, $keterangan, $penanggung_jawab;

    public function mount()
    {
        $this->tanggal_mutasi = date('Y-m-d');
        $this->penanggung_jawab = Auth::user()->name ?? 'Admin';
    }

    public function create()
    {
        $this->reset(['barang_id', 'ruangan_id_asal', 'ruangan_id_tujuan', 'jumlah', 'keterangan']);
        $this->tanggal_mutasi = date('Y-m-d');
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'ruangan_id_asal' => 'required|exists:ruangans,id',
            'ruangan_id_tujuan' => 'required|exists:ruangans,id|different:ruangan_id_asal',
            'jumlah' => 'required|integer|min:1',
            'tanggal_mutasi' => 'required|date',
            'penanggung_jawab' => 'required|string',
        ]);

        // Logic transaksi DB untuk konsistensi data
        DB::transaction(function () {
            // 1. Simpan Riwayat Mutasi
            $mutasi = MutasiBarang::create([
                'barang_id' => $this->barang_id,
                'ruangan_id_asal' => $this->ruangan_id_asal,
                'ruangan_id_tujuan' => $this->ruangan_id_tujuan,
                'jumlah' => $this->jumlah,
                'tanggal_mutasi' => $this->tanggal_mutasi,
                'penanggung_jawab' => $this->penanggung_jawab,
                'keterangan' => $this->keterangan,
                // Simpan nama lokasi text juga untuk historical jika ruangan dihapus
                'lokasi_asal' => Ruangan::find($this->ruangan_id_asal)->nama_ruangan,
                'lokasi_tujuan' => Ruangan::find($this->ruangan_id_tujuan)->nama_ruangan,
            ]);

            // 2. Update Stok Ruangan (Logic: Kurangi Asal, Tambah Tujuan)
            // Asumsi: Ada tabel pivot 'barang_ruangan' atau fitur stok per ruangan.
            // Jika belum ada, kita update lokasi utama barang jika jumlah mutasi = total stok (pindah penuh)
            
            // TODO: Implementasi update stok fisik jika fitur multi-gudang aktif.
            // Untuk saat ini, kita catat riwayatnya saja sebagai "Paper Trail".
        });

        $this->isModalOpen = false;
        $this->dispatch('notify', type: 'success', message: 'Mutasi barang berhasil dicatat.');
    }

    public function render()
    {
        $mutasi = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
            ->when($this->search, function($q) {
                $q->whereHas('barang', function($b) {
                    $b->where('nama_barang', 'like', '%'.$this->search.'%');
                })->orWhere('penanggung_jawab', 'like', '%'.$this->search.'%');
            })
            ->latest('tanggal_mutasi')
            ->paginate($this->perPage);

        return view('livewire.barang.mutasi.index', [
            'mutasi' => $mutasi,
            'barangs' => Barang::select('id', 'nama_barang', 'kode_barang')->orderBy('nama_barang')->get(),
            'ruangans' => Ruangan::select('id', 'nama_ruangan')->orderBy('nama_ruangan')->get(),
        ])->layout('layouts.app', ['header' => 'Mutasi & Perpindahan Aset']);
    }
}