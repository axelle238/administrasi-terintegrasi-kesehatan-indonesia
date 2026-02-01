<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\AlurPelayanan as AlurModel;
use App\Models\JenisPelayanan;

class AlurPelayanan extends Component
{
    public $activeTab = 0; // ID of active JenisPelayanan
    public $search = '';

    public function mount()
    {
        // Set default active tab to the first JenisPelayanan that has alurs
        $first = JenisPelayanan::whereHas('alurPelayanans')->first();
        if ($first) {
            $this->activeTab = $first->id;
        }
    }

    public function setActiveTab($id)
    {
        $this->activeTab = $id;
    }

    public function render()
    {
        // Get all types that have alurs for tabs
        $jenisPelayanans = JenisPelayanan::whereHas('alurPelayanans')
            ->where('is_active', true)
            ->get();

        // Get alurs for active tab
        $alurs = AlurModel::where('jenis_pelayanan_id', $this->activeTab)
            ->where('is_active', true)
            ->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->orderBy('urutan')
            ->get();

        return view('livewire.public.alur-pelayanan', [
            'jenisPelayanans' => $jenisPelayanans,
            'alurs' => $alurs
        ])->layout('layouts.guest'); // Assuming guest layout for public pages
    }
}