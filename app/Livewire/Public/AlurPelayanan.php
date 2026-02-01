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
    
    // Smart Filter
    public $selectedPatientType = 'Umum'; // Umum, BPJS, Asuransi

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
        $firstLayanan = JenisPelayanan::where('poli_id', $id)->where('is_active', true)->first();
        $this->activeLayanan = $firstLayanan ? $firstLayanan->id : null;
    }

    public function setLayanan($id)
    {
        $this->activeLayanan = $id;
    }
    
    public function setPatientType($type)
    {
        $this->selectedPatientType = $type;
    }

    public function render()
    {
        $polis = Poli::whereHas('jenisPelayanans', function($q) {
            $q->where('is_active', true);
        })->get();

        $layanans = [];
        if ($this->activePoli) {
            $layanans = JenisPelayanan::where('poli_id', $this->activePoli)
                ->where('is_active', true)
                ->get();
        }

        $alurs = collect([]);
        if ($this->activeLayanan) {
            $query = AlurModel::where('jenis_pelayanan_id', $this->activeLayanan)
                ->where('is_active', true)
                ->where(function($q) {
                    $q->where('judul', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                })
                ->orderBy('urutan')
                ->get();
            
            // Filter Logic in PHP because JSON querying varies by DB version
            $alurs = $query->filter(function($alur) {
                $rules = $alur->visibility_rules;
                
                // If no rules, show to everyone
                if (empty($rules) || empty($rules['target_pasien'])) {
                    return true;
                }
                
                // If rules exist, check if current selection is allowed
                return in_array($this->selectedPatientType, $rules['target_pasien']);
            });
        }

        return view('livewire.public.alur-pelayanan', [
            'polis' => $polis,
            'layanans' => $layanans,
            'alurs' => $alurs,
            'currentLayanan' => JenisPelayanan::find($this->activeLayanan)
        ])->layout('layouts.guest');
    }
}