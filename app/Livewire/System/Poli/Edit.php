<?php

namespace App\Livewire\System\Poli;

use App\Models\Poli;
use Livewire\Component;

class Edit extends Component
{
    public Poli $poli;
    public $nama_poli;
    public $kode_poli;
    public $keterangan;

    protected function rules()
    {
        return [
            'nama_poli' => 'required|string|max:255',
            'kode_poli' => 'required|string|max:10|unique:polis,kode_poli,' . $this->poli->id,
            'keterangan' => 'nullable|string',
        ];
    }

    public function mount(Poli $poli)
    {
        $this->poli = $poli;
        $this->nama_poli = $poli->nama_poli;
        $this->kode_poli = $poli->kode_poli;
        $this->keterangan = $poli->keterangan;
    }

    public function save()
    {
        $this->validate();

        $this->poli->update([
            'nama_poli' => $this->nama_poli,
            'kode_poli' => $this->kode_poli,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Poli berhasil diperbarui.');
        return $this->redirect(route('system.poli.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.system.poli.edit')->layout('layouts.app', ['header' => 'Edit Poli']);
    }
}
