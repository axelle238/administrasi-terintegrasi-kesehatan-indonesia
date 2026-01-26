<?php

namespace App\Livewire\Masyarakat;

use Livewire\Component;
use App\Models\KegiatanUkm;
use App\Models\Survey;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // Menampilkan data kegiatan UKM yang relevan untuk masyarakat
        $kegiatans = KegiatanUkm::where('nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orWhere('lokasi', 'like', '%' . $this->search . '%')
            ->latest('tanggal_kegiatan')
            ->paginate(9);

        // Menampilkan survey kepuasan yang aktif (opsional di dashboard ini atau terpisah)
        $activeSurveys = Survey::count();

        return view('livewire.masyarakat.index', [
            'kegiatans' => $kegiatans,
            'activeSurveys' => $activeSurveys
        ])->layout('layouts.app', ['header' => 'Layanan Masyarakat & UKM']);
    }
}
