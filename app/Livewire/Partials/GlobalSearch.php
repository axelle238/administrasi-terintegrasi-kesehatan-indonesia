<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\Pegawai;
use App\Models\Obat;
use App\Models\Barang;
use App\Models\User;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        $this->results = [];

        if (strlen($this->query) < 2) {
            return;
        }

        // Cari Pasien
        $pasiens = Pasien::where('nama_pasien', 'like', '%' . $this->query . '%')
            ->orWhere('no_rm', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Pasien',
                    'title' => $item->nama_pasien,
                    'subtitle' => $item->no_rm,
                    'url' => route('pasien.show', $item->id), // Asumsi route ada
                    'icon' => 'user'
                ];
            });

        // Cari Pegawai
        $pegawais = User::where('name', 'like', '%' . $this->query . '%')
            ->whereHas('pegawai') // Hanya user yang pegawai
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Pegawai',
                    'title' => $item->name,
                    'subtitle' => $item->pegawai->jabatan ?? 'Staf',
                    'url' => route('pegawai.edit', $item->pegawai->id),
                    'icon' => 'badge'
                ];
            });

        // Cari Obat
        $obats = Obat::where('nama_obat', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Obat',
                    'title' => $item->nama_obat,
                    'subtitle' => 'Stok: ' . $item->stok,
                    'url' => route('obat.edit', $item->id),
                    'icon' => 'pill'
                ];
            });

        // Cari Aset
        $barangs = Barang::where('nama_barang', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Aset',
                    'title' => $item->nama_barang,
                    'subtitle' => $item->kode_barang,
                    'url' => route('barang.show', $item->id),
                    'icon' => 'box'
                ];
            });

        $this->results = $pasiens->merge($pegawais)->merge($obats)->merge($barangs)->toArray();
    }

    public function render()
    {
        return view('livewire.partials.global-search');
    }
}
