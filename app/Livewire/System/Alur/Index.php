<?php

namespace App\Livewire\System\Alur;

use Livewire\Component;
use App\Models\Poli;
use App\Models\JenisPelayanan;

class Index extends Component
{
    // State untuk form Jenis Pelayanan (Bukan Alur)
    public $jenisId;
    public $poli_id;
    public $nama_layanan;
    public $deskripsi;
    public $is_active = true;
    public $icon = 'heroicon-o-cube';

    public $isFormOpen = false;

    protected $rules = [
        'poli_id' => 'required|exists:polis,id',
        'nama_layanan' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ];

    public function render()
    {
        // Ambil Poli beserta Jenis Pelayanannya
        $polis = Poli::with(['jenisPelayanans' => function($q) {
            $q->withCount('alurPelayanans');
        }])->get();

        return view('livewire.system.alur.index', [
            'polis' => $polis,
            'listPolis' => Poli::all(), // Untuk dropdown di form
        ])->layout('layouts.app', ['header' => 'Master Alur Pelayanan']);
    }

    public function create()
    {
        $this->resetInput();
        $this->isFormOpen = true;
    }

    public function edit($id)
    {
        $jenis = JenisPelayanan::find($id);
        $this->jenisId = $id;
        $this->poli_id = $jenis->poli_id;
        $this->nama_layanan = $jenis->nama_layanan;
        $this->deskripsi = $jenis->deskripsi;
        $this->is_active = $jenis->is_active;
        $this->icon = $jenis->icon;
        
        $this->isFormOpen = true;
    }

    public function store()
    {
        $this->validate();

        JenisPelayanan::updateOrCreate(['id' => $this->jenisId], [
            'poli_id' => $this->poli_id,
            'nama_layanan' => $this->nama_layanan,
            'deskripsi' => $this->deskripsi,
            'is_active' => $this->is_active,
            'icon' => $this->icon,
        ]);

        $this->dispatch('notify', 'success', 'Jenis Pelayanan berhasil disimpan.');
        $this->cancel();
    }

    public function delete($id)
    {
        JenisPelayanan::find($id)->delete();
        $this->dispatch('notify', 'success', 'Jenis Pelayanan dihapus.');
    }

    public function cancel()
    {
        $this->isFormOpen = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->reset(['jenisId', 'poli_id', 'nama_layanan', 'deskripsi', 'is_active', 'icon']);
    }
}
