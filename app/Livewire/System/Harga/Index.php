<?php

namespace App\Livewire\System\Harga;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tindakan;
use App\Models\Poli;

class Index extends Component
{
    use WithPagination;

    public $tindakanId;
    public $nama_tindakan, $kategori, $deskripsi, $harga, $is_active = true, $poli_id;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'nama_tindakan' => 'required',
        'harga' => 'required|numeric',
        'kategori' => 'required',
    ];

    public function render()
    {
        $tindakans = Tindakan::query()
            ->when($this->search, function($q) {
                $q->where('nama_tindakan', 'like', '%'.$this->search.'%')
                  ->orWhere('kategori', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.system.harga.index', [
            'tindakans' => $tindakans,
            'polis' => Poli::all(),
        ])->layout('layouts.app', ['header' => 'Katalog Harga Layanan']);
    }

    public function create()
    {
        $this->resetInput();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $tindakan = Tindakan::find($id);
        $this->tindakanId = $id;
        $this->nama_tindakan = $tindakan->nama_tindakan;
        $this->kategori = $tindakan->kategori;
        $this->deskripsi = $tindakan->deskripsi;
        $this->harga = $tindakan->harga;
        $this->is_active = $tindakan->is_active;
        $this->poli_id = $tindakan->poli_id;
        $this->isEditing = true;
    }

    public function store()
    {
        $this->validate();

        Tindakan::updateOrCreate(['id' => $this->tindakanId], [
            'nama_tindakan' => $this->nama_tindakan,
            'kategori' => $this->kategori,
            'deskripsi' => $this->deskripsi,
            'harga' => $this->harga,
            'is_active' => $this->is_active,
            'poli_id' => $this->poli_id,
        ]);

        $this->isEditing = false;
        $this->resetInput();
        $this->dispatch('notify', 'success', 'Data layanan berhasil disimpan.');
    }

    public function delete($id)
    {
        Tindakan::find($id)->delete();
        $this->dispatch('notify', 'success', 'Data layanan dihapus.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->reset(['tindakanId', 'nama_tindakan', 'kategori', 'deskripsi', 'harga', 'is_active', 'poli_id']);
    }
}
