<?php

namespace App\Livewire\System\Alur;

use Livewire\Component;
use App\Models\AlurPelayanan;

class Index extends Component
{
    public $alurId;
    public $judul, $deskripsi, $icon = 'check-circle', $urutan, $is_active = true;
    public $isEditing = false;

    protected $rules = [
        'judul' => 'required',
        'urutan' => 'required|integer',
    ];

    public function render()
    {
        return view('livewire.system.alur.index', [
            'alurs' => AlurPelayanan::orderBy('urutan')->get()
        ])->layout('layouts.app', ['header' => 'Manajemen Alur Pelayanan']);
    }

    public function create()
    {
        $this->resetInput();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $alur = AlurPelayanan::find($id);
        $this->alurId = $id;
        $this->judul = $alur->judul;
        $this->deskripsi = $alur->deskripsi;
        $this->icon = $alur->icon;
        $this->urutan = $alur->urutan;
        $this->is_active = $alur->is_active;
        $this->isEditing = true;
    }

    public function store()
    {
        $this->validate();

        AlurPelayanan::updateOrCreate(['id' => $this->alurId], [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'icon' => $this->icon,
            'urutan' => $this->urutan,
            'is_active' => $this->is_active,
        ]);

        $this->isEditing = false;
        $this->resetInput();
        $this->dispatch('notify', 'success', 'Alur pelayanan berhasil disimpan.');
    }

    public function delete($id)
    {
        AlurPelayanan::find($id)->delete();
        $this->dispatch('notify', 'success', 'Alur dihapus.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->reset(['alurId', 'judul', 'deskripsi', 'icon', 'urutan', 'is_active']);
    }
}
