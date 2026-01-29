<?php

namespace App\Livewire\Admin\Fasilitas;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Fasilitas $fasilitas;
    public $nama_fasilitas;
    public $deskripsi;
    public $jenis;
    public $is_active;
    public $gambar;
    public $oldGambar;

    protected $rules = [
        'nama_fasilitas' => 'required|min:3|max:255',
        'deskripsi' => 'nullable|string',
        'jenis' => 'required|in:medis,non-medis,unggulan',
        'is_active' => 'boolean',
        'gambar' => 'nullable|image|max:2048',
    ];

    public function mount(Fasilitas $fasilitas)
    {
        $this->fasilitas = $fasilitas;
        $this->nama_fasilitas = $fasilitas->nama_fasilitas;
        $this->deskripsi = $fasilitas->deskripsi;
        $this->jenis = $fasilitas->jenis;
        $this->is_active = $fasilitas->is_active;
        $this->oldGambar = $fasilitas->gambar;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_fasilitas' => $this->nama_fasilitas,
            'deskripsi' => $this->deskripsi,
            'jenis' => $this->jenis,
            'is_active' => $this->is_active,
        ];

        if ($this->gambar) {
            // Delete old gambar if exists
            if ($this->oldGambar && Storage::disk('public')->exists($this->oldGambar)) {
                Storage::disk('public')->delete($this->oldGambar);
            }
            $data['gambar'] = $this->gambar->store('fasilitas-images', 'public');
        }

        $this->fasilitas->update($data);

        $this->dispatch('notify', 'success', 'Fasilitas berhasil diperbarui.');
        return redirect()->route('admin.fasilitas.index');
    }

    public function render()
    {
        return view('livewire.admin.fasilitas.edit')
            ->layout('layouts.app', ['header' => 'Edit Fasilitas']);
    }
}