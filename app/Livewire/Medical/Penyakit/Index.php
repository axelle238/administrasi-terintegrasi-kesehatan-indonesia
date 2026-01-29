<?php

namespace App\Livewire\Medical\Penyakit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Icd10;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterBpjs = ''; // 'all', '1', '0'

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Icd10::query();

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->filterBpjs !== '') {
            $query->where('is_bpjs', $this->filterBpjs);
        }

        $penyakit = $query->orderBy('code')->paginate(15);

        return view('livewire.medical.penyakit.index', [
            'penyakit' => $penyakit
        ])->layout('layouts.app', ['header' => 'Kamus Diagnosa Penyakit (ICD-10)']);
    }
}