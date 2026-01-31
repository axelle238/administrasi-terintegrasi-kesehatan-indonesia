<?php

namespace App\Livewire\Barang\Mutasi;

use App\Models\MutasiBarang;
use App\Models\Barang;
use App\Models\Ruangan;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $barang_id, $ruangan_id_asal, $ruangan_id_tujuan, $jumlah, $tanggal_mutasi, $keterangan, $penanggung_jawab;

    public function mount()
    {
        $this->tanggal_mutasi = date('Y-m-d');
        $this->penanggung_jawab = Auth::user()->name ?? 'Admin';
    }

    public function updatedBarangId($value)
    {
        if ($value) {
            $barang = Barang::find($value);
            if ($barang && $barang->ruangan_id) {
                $this->ruangan_id_asal = $barang->ruangan_id;
            }
        }
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

        DB::transaction(function () {
            MutasiBarang::create([
                'barang_id' => $this->barang_id,
                'ruangan_id_asal' => $this->ruangan_id_asal,
                'ruangan_id_tujuan' => $this->ruangan_id_tujuan,
                'jumlah' => $this->jumlah,
                'tanggal_mutasi' => $this->tanggal_mutasi,
                'penanggung_jawab' => $this->penanggung_jawab,
                'keterangan' => $this->keterangan,
                'lokasi_asal' => Ruangan::find($this->ruangan_id_asal)->nama_ruangan,
                'lokasi_tujuan' => Ruangan::find($this->ruangan_id_tujuan)->nama_ruangan,
            ]);
        });

        $this->dispatch('notify', 'success', 'Mutasi barang berhasil dicatat.');
        return $this->redirect(route('barang.mutasi.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.mutasi.create', [
            'barangs' => Barang::select('id', 'nama_barang', 'kode_barang', 'stok', 'ruangan_id')->orderBy('nama_barang')->get(),
            'ruangans' => Ruangan::select('id', 'nama_ruangan')->orderBy('nama_ruangan')->get(),
        ])->layout('layouts.app', ['header' => 'Catat Mutasi Baru']);
    }
}
