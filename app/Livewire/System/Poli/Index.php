<?php

namespace App\Livewire\System\Poli;

use App\Models\Poli;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $poliId;
    public $nama_poli;
    public $kode_poli;
    public $keterangan;

    protected $rules = [
        'nama_poli' => 'required|string|max:255',
        'kode_poli' => 'required|string|max:10|unique:polis,kode_poli',
        'keterangan' => 'nullable|string',
    ];

    public function create()
    {
        $this->reset(['poliId', 'nama_poli', 'kode_poli', 'keterangan']);
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $poli = Poli::findOrFail($id);
        $this->poliId = $id;
        $this->nama_poli = $poli->nama_poli;
        $this->kode_poli = $poli->kode_poli;
        $this->keterangan = $poli->keterangan;
        $this->isOpen = true;
    }

    public function save()
    {
        if ($this->poliId) {
            $this->validate([
                'nama_poli' => 'required|string|max:255',
                'kode_poli' => 'required|string|max:10|unique:polis,kode_poli,' . $this->poliId,
                'keterangan' => 'nullable|string',
            ]);
            
            Poli::find($this->poliId)->update([
                'nama_poli' => $this->nama_poli,
                'kode_poli' => $this->kode_poli,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatch('notify', 'success', 'Poli berhasil diperbarui.');
        } else {
            $this->validate();
            Poli::create([
                'nama_poli' => $this->nama_poli,
                'kode_poli' => $this->kode_poli,
                'keterangan' => $this->keterangan,
            ]);
            $this->dispatch('notify', 'success', 'Poli berhasil ditambahkan.');
        }

        $this->isOpen = false;
    }

    public function delete($id)
    {
        Poli::find($id)->delete();
        $this->dispatch('notify', 'success', 'Poli dihapus.');
    }

    public function render()
    {
        $polis = Poli::where('nama_poli', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.system.poli.index', [
            'polis' => $polis
        ])->layout('layouts.app', ['header' => 'Master Data Poli']);
    }
}