<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Berita $berita;
    public $judul;
    public $konten;
    public $kategori;
    public $status;
    public $thumbnail;
    public $oldThumbnail;

    protected $rules = [
        'judul' => 'required|min:5|max:255',
        'konten' => 'required|min:20',
        'kategori' => 'required',
        'status' => 'required|in:draft,published',
        'thumbnail' => 'nullable|image|max:2048',
    ];

    public function mount(Berita $berita)
    {
        $this->berita = $berita;
        $this->judul = $berita->judul;
        $this->konten = $berita->konten;
        $this->kategori = $berita->kategori;
        $this->status = $berita->status;
        $this->oldThumbnail = $berita->thumbnail;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'konten' => $this->konten,
            'kategori' => $this->kategori,
            'status' => $this->status,
        ];

        // Update Slug if title changes
        if ($this->judul !== $this->berita->judul) {
            $data['slug'] = Str::slug($this->judul) . '-' . Str::random(5);
        }

        if ($this->thumbnail) {
            // Delete old thumbnail if exists
            if ($this->oldThumbnail && Storage::disk('public')->exists($this->oldThumbnail)) {
                Storage::disk('public')->delete($this->oldThumbnail);
            }
            $data['thumbnail'] = $this->thumbnail->store('berita-thumbnails', 'public');
        }

        $this->berita->update($data);

        $this->dispatch('notify', 'success', 'Berita berhasil diperbarui.');
        return redirect()->route('admin.berita.index');
    }

    public function render()
    {
        return view('livewire.admin.berita.edit')
            ->layout('layouts.app', ['header' => 'Edit Berita']);
    }
}