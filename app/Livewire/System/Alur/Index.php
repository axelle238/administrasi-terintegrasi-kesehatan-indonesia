<?php

namespace App\Livewire\System\Alur;

use Livewire\Component;
use App\Models\AlurPelayanan;

class Index extends Component
{
    public $alurId;
    public $judul, $deskripsi, $icon = 'check-circle', $urutan, $is_active = true;
    
    // New Fields
    public $target_pasien = 'Umum', $estimasi_waktu, $dokumen_syarat;
    
    public $isEditing = false;

    protected $rules = [
        'judul' => 'required',
        'urutan' => 'required|integer',
        'target_pasien' => 'required',
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
        
        $this->target_pasien = $alur->target_pasien;
        $this->estimasi_waktu = $alur->estimasi_waktu;
        $this->dokumen_syarat = $alur->dokumen_syarat;
        
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
            'target_pasien' => $this->target_pasien,
            'estimasi_waktu' => $this->estimasi_waktu,
            'dokumen_syarat' => $this->dokumen_syarat,
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
        $this->reset(['alurId', 'judul', 'deskripsi', 'icon', 'urutan', 'is_active', 'target_pasien', 'estimasi_waktu', 'dokumen_syarat']);
    }
}