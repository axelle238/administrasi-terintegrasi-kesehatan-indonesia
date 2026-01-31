<?php

namespace App\Livewire\Barang\Mutasi;

use App\Models\MutasiBarang;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    #[Url]
    public $barang_id;

    public $ruangan_id_asal;
    public $nama_ruangan_asal; // Untuk display
    public $ruangan_id_tujuan;
    
    public $tanggal_mutasi;
    public $penanggung_jawab;
    public $keterangan;

    public function mount()
    {
        $this->tanggal_mutasi = date('Y-m-d');
        $this->penanggung_jawab = Auth::user()->name ?? '-';

        // Jika ada parameter URL barang_id (dari halaman Detail)
        if ($this->barang_id) {
            $this->loadBarangInfo($this->barang_id);
        }
    }

    public function updatedBarangId($value)
    {
        $this->loadBarangInfo($value);
    }

    private function loadBarangInfo($id)
    {
        $barang = Barang::with('ruangan')->find($id);
        if ($barang) {
            $this->ruangan_id_asal = $barang->ruangan_id;
            $this->nama_ruangan_asal = $barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan ?? 'Belum Ditentukan';
        } else {
            $this->reset(['ruangan_id_asal', 'nama_ruangan_asal']);
        }
    }

    public function save()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'ruangan_id_tujuan' => 'required|exists:ruangans,id|different:ruangan_id_asal',
            'tanggal_mutasi' => 'required|date',
            'penanggung_jawab' => 'required|string',
        ], [
            'ruangan_id_tujuan.different' => 'Ruangan tujuan harus berbeda dengan ruangan asal.'
        ]);

        DB::transaction(function () {
            $barang = Barang::find($this->barang_id);
            $ruanganTujuan = Ruangan::find($this->ruangan_id_tujuan);
            
            // 1. Catat Mutasi
            MutasiBarang::create([
                'barang_id' => $this->barang_id,
                'ruangan_id_asal' => $this->ruangan_id_asal,
                'lokasi_asal' => $this->nama_ruangan_asal,
                'ruangan_id_tujuan' => $this->ruangan_id_tujuan,
                'lokasi_tujuan' => $ruanganTujuan->nama_ruangan,
                'jumlah' => 1, // Asumsi mutasi per unit asset, atau bisa ditambah field jumlah jika consumable
                'tanggal_mutasi' => $this->tanggal_mutasi,
                'penanggung_jawab' => $this->penanggung_jawab,
                'keterangan' => $this->keterangan,
            ]);

            // 2. Update Lokasi Barang Real
            $barang->update([
                'ruangan_id' => $this->ruangan_id_tujuan,
                'lokasi_penyimpanan' => $ruanganTujuan->nama_ruangan
            ]);

            // 3. Catat di Log Riwayat Barang (Agar muncul di timeline)
            RiwayatBarang::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jenis_transaksi' => 'Mutasi Keluar', // Atau jenis khusus 'Mutasi'
                'jumlah' => 0, // Mutasi lokasi tidak mengubah stok total
                'stok_terakhir' => $barang->stok,
                'tanggal' => $this->tanggal_mutasi,
                'keterangan' => "Pindah ke " . $ruanganTujuan->nama_ruangan . " (Oleh: $this->penanggung_jawab)"
            ]);
        });

        $this->dispatch('notify', 'success', 'Aset berhasil dipindahkan.');
        return $this->redirect(route('barang.mutasi.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.mutasi.create', [
            'barangs' => Barang::orderBy('nama_barang')->get(),
            'ruangans' => Ruangan::orderBy('nama_ruangan')->get(),
        ])->layout('layouts.app', ['header' => 'Form Mutasi Aset']);
    }
}