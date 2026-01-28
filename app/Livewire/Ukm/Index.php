<?php

namespace App\Livewire\Ukm;

use App\Models\KegiatanUkm;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $kegiatan = KegiatanUkm::find($id);
        if ($kegiatan) {
            $kegiatan->delete();
            $this->dispatch('notify', 'success', 'Data kegiatan UKM berhasil dihapus.');
        }
    }

    public function render()
    {
        $kegiatans = KegiatanUkm::with('user')
            ->where(function($q) {
                $q->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_kegiatan', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->search . '%');
            })
            ->latest('tanggal_kegiatan')
            ->paginate(10);

        return view('livewire.ukm.index', [
            'kegiatans' => $kegiatans
        ])->layout('layouts.app', ['header' => 'Upaya Kesehatan Masyarakat (UKM)']);
    }
}