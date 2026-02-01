<?php

namespace App\Livewire\System\JenisPelayanan;

use Livewire\Component;
use App\Models\JenisPelayanan;

class Index extends Component
{
    public $jenisId;
    public $nama_layanan, $deskripsi, $icon = 'server', $is_active = true;
    public $isEditing = false;

    protected $rules = [
        'nama_layanan' => 'required|string|max:255',
        'icon' => 'required|string|max:50',
    ];

    public function render()
    {
        return view('livewire.system.jenis-pelayanan.index', [
            'jenisPelayanans' => JenisPelayanan::latest()->get()
        ])->layout('layouts.app', ['header' => 'Master Jenis Pelayanan']);
    }

    public function create()
    {
        $this->resetInput();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $jenis = JenisPelayanan::findOrFail($id);
        $this->jenisId = $id;
        $this->nama_layanan = $jenis->nama_layanan;
        $this->deskripsi = $jenis->deskripsi;
        $this->icon = $jenis->icon;
        $this->is_active = $jenis->is_active;
        $this->isEditing = true;
    }

    public function store()
    {
        $this->validate();

        JenisPelayanan::updateOrCreate(['id' => $this->jenisId], [
            'nama_layanan' => $this->nama_layanan,
            'deskripsi' => $this->deskripsi,
            'icon' => $this->icon,
            'is_active' => $this->is_active,
        ]);

        $this->isEditing = false;
        $this->resetInput();
        $this->dispatch('notify', 'success', 'Jenis pelayanan berhasil disimpan.');
    }

    public function delete($id)
    {
        // Cek relasi jika perlu, tapi karena cascade/set null aman
        JenisPelayanan::findOrFail($id)->delete();
        $this->dispatch('notify', 'success', 'Jenis pelayanan dihapus.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->reset(['jenisId', 'nama_layanan', 'deskripsi', 'icon', 'is_active']);
    }
}
