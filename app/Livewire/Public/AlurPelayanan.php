<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Poli;
use App\Models\JenisPelayanan;
use App\Models\AlurPelayanan as AlurModel;

class AlurPelayanan extends Component
{
    public $activePoli = null;
    public $activeLayanan = null;
    public $search = '';

    public function mount()
    {
        // Default ke Poli pertama yang punya layanan aktif
        $firstPoli = Poli::whereHas('jenisPelayanans', function($q) {
            $q->where('is_active', true);
        })->first();

        if ($firstPoli) {
            $this->activePoli = $firstPoli->id;
            
            // Default ke layanan pertama di poli tersebut
            $firstLayanan = $firstPoli->jenisPelayanans()->where('is_active', true)->first();
            if ($firstLayanan) {
                $this->activeLayanan = $firstLayanan->id;
            }
        }
    }

    public function setPoli($id)
    {
        $this->activePoli = $id;
        // Reset layanan ke yang pertama di poli ini
        $firstLayanan = JenisPelayanan::where('poli_id', $id)->where('is_active', true)->first();
        $this->activeLayanan = $firstLayanan ? $firstLayanan->id : null;
    }

    public function setLayanan($id)
    {
        $this->activeLayanan = $id;
    }

    public function render()
    {
        // Ambil semua Poli yang punya layanan aktif
        $polis = Poli::whereHas('jenisPelayanans', function($q) {
            $q->where('is_active', true);
        })->get();

        // Ambil Jenis Pelayanan berdasarkan Poli aktif
        $layanans = [];
        if ($this->activePoli) {
            $layanans = JenisPelayanan::where('poli_id', $this->activePoli)
                ->where('is_active', true)
                ->get();
        }

        // Ambil Alur berdasarkan Layanan aktif + Search
        $alurs = [];
        if ($this->activeLayanan) {
            $alurs = AlurModel::where('jenis_pelayanan_id', $this->activeLayanan)
                ->where('is_active', true)
                ->where(function($q) {
                    $q->where('judul', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                })
                ->orderBy('urutan')
                ->get();
        }

        return view('livewire.public.alur-pelayanan', [
            'polis' => $polis,
            'layanans' => $layanans,
            'alurs' => $alurs,
            'currentLayanan' => JenisPelayanan::find($this->activeLayanan)
        ])->layout('layouts.guest');
    }
}
