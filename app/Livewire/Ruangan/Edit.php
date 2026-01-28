<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Ruangan $ruangan;
    
    public $kode_ruangan;
    public $nama_ruangan;
    public $lokasi_gedung;
    public $penanggung_jawab;
    public $keterangan;

    public function mount(Ruangan $ruangan)
    {
        $this->ruangan = $ruangan;
        $this->kode_ruangan = $ruangan->kode_ruangan;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->lokasi_gedung = $ruangan->lokasi_gedung;
        $this->penanggung_jawab = $ruangan->penanggung_jawab;
        $this->keterangan = $ruangan->keterangan;
    }

    protected function rules()
    {
        return [
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => ['nullable', 'string', 'max:255', Rule::unique('ruangans')->ignore($this->ruangan->id)],
            'lokasi_gedung' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->ruangan->update([
            'kode_ruangan' => $this->kode_ruangan,
            'nama_ruangan' => $this->nama_ruangan,
            'lokasi_gedung' => $this->lokasi_gedung,
            'penanggung_jawab' => $this->penanggung_jawab,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Data ruangan berhasil diperbarui.');
        return $this->redirect(route('ruangan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.ruangan.edit')->layout('layouts.app', ['header' => 'Edit Ruangan']);
    }
}
