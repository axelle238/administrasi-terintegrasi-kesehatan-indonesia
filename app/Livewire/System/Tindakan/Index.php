<?php

namespace App\Livewire\System\Tindakan;

use App\Models\Tindakan;
use App\Models\Poli; // Use Poli model for dropdown
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $tindakanId;
    
    public $nama_tindakan;
    public $poli_id;
    public $harga;

    protected $rules = [
        'nama_tindakan' => 'required|string|max:255',
        'poli_id' => 'required|exists:polis,id',
        'harga' => 'required|numeric|min:0',
    ];

    public function create()
    {
        $this->reset(['tindakanId', 'nama_tindakan', 'poli_id', 'harga']);
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $this->tindakanId = $id;
        $this->nama_tindakan = $tindakan->nama_tindakan;
        $this->poli_id = $tindakan->poli_id;
        $this->harga = $tindakan->harga;
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->tindakanId) {
            Tindakan::find($this->tindakanId)->update([
                'nama_tindakan' => $this->nama_tindakan,
                'poli_id' => $this->poli_id,
                'harga' => $this->harga,
            ]);
            $this->dispatch('notify', 'success', 'Tindakan berhasil diperbarui.');
        } else {
            Tindakan::create([
                'nama_tindakan' => $this->nama_tindakan,
                'poli_id' => $this->poli_id,
                'harga' => $this->harga,
            ]);
            $this->dispatch('notify', 'success', 'Tindakan berhasil ditambahkan.');
        }

        $this->isOpen = false;
    }

    public function delete($id)
    {
        Tindakan::find($id)->delete();
        $this->dispatch('notify', 'success', 'Tindakan dihapus.');
    }

    public function render()
    {
        $tindakans = Tindakan::with('poli')
            ->where('nama_tindakan', 'like', '%' . $this->search . '%')
            ->orWhereHas('poli', function($q) {
                $q->where('nama_poli', 'like', '%' . $this->search . '%');
            })
            ->orderBy('poli_id')
            ->paginate(10);

        // Get unique Poli names from Poli model
        $polis = Poli::all(); 

        return view('livewire.system.tindakan.index', [
            'tindakans' => $tindakans,
            'polis' => $polis
        ])->layout('layouts.app', ['header' => 'Master Data Tindakan & Tarif']);
    }
}