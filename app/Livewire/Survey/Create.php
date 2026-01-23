<?php

namespace App\Livewire\Survey;

use App\Models\Poli;
use App\Models\Survey; // Assuming model created automatically or I use DB
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $poli_id;
    public $nilai = 5;
    public $kritik_saran;
    public $isSubmitted = false;

    protected $rules = [
        'poli_id' => 'required|exists:polis,id',
        'nilai' => 'required|integer|min:1|max:5',
        'kritik_saran' => 'nullable|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        DB::table('surveys')->insert([
            'poli_id' => $this->poli_id,
            'nilai' => $this->nilai,
            'kritik_saran' => $this->kritik_saran,
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('livewire.survey.create', [
            'polis' => Poli::all()
        ])->layout('layouts.guest'); // Use guest layout
    }
}
