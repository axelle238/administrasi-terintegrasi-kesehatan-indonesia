<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $deleteId = '';
    public $showDeleteModal = false;

    // Form Fields
    public $ruanganId;
    public $kode_ruangan;
    public $nama_ruangan;
    public $lokasi_gedung;
    public $penanggung_jawab;
    public $keterangan;

    public function render()
    {
        $ruangans = Ruangan::query()
            ->where(function($q) {
                $q->where('nama_ruangan', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_ruangan', 'like', '%' . $this->search . '%')
                  ->orWhere('penanggung_jawab', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_ruangan')
            ->paginate(10);

        return view('livewire.ruangan.index', [
            'ruangans' => $ruangans
        ])->layout('layouts.app', ['header' => 'Manajemen Ruangan']);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'ruangan-modal');
    }

    public function edit(Ruangan $ruangan)
    {
        $this->resetForm();
        $this->ruanganId = $ruangan->id;
        $this->kode_ruangan = $ruangan->kode_ruangan;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->lokasi_gedung = $ruangan->lokasi_gedung;
        $this->penanggung_jawab = $ruangan->penanggung_jawab;
        $this->keterangan = $ruangan->keterangan;
        $this->showModal = true;
        $this->dispatch('open-modal', 'ruangan-modal');
    }

    public function store()
    {
        $this->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => ['nullable', 'string', 'max:255', Rule::unique('ruangans')->ignore($this->ruanganId)],
            'lokasi_gedung' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Ruangan::updateOrCreate(
            ['id' => $this->ruanganId],
            [
                'kode_ruangan' => $this->kode_ruangan,
                'nama_ruangan' => $this->nama_ruangan,
                'lokasi_gedung' => $this->lokasi_gedung,
                'penanggung_jawab' => $this->penanggung_jawab,
                'keterangan' => $this->keterangan,
            ]
        );

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('notify', message: 'Data ruangan berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $ruangan = Ruangan::find($this->deleteId);
        if ($ruangan) {
            $ruangan->delete();
            $this->dispatch('notify', message: 'Data ruangan berhasil dihapus.');
        }
        $this->showDeleteModal = false;
    }

    public function resetForm()
    {
        $this->ruanganId = null;
        $this->kode_ruangan = '';
        $this->nama_ruangan = '';
        $this->lokasi_gedung = '';
        $this->penanggung_jawab = '';
        $this->keterangan = '';
        $this->resetErrorBag();
    }
}
