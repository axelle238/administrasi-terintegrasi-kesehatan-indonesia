<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    public $judul;
    public $konten;
    public $kategori = 'Umum';
    public $status = 'published';
    public $thumbnail;

    protected $rules = [
        'judul' => 'required|min:5|max:255',
        'konten' => 'required|min:20',
        'kategori' => 'required',
        'status' => 'required|in:draft,published',
        'thumbnail' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function save()
    {
        $this->validate();

        $thumbnailPath = null;
        if ($this->thumbnail) {
            $thumbnailPath = $this->thumbnail->store('berita-thumbnails', 'public');
        }

        Berita::create([
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul) . '-' . Str::random(5),
            'konten' => $this->konten,
            'kategori' => $this->kategori,
            'status' => $this->status,
            'thumbnail' => $thumbnailPath,
            'user_id' => Auth::id(),
        ]);

        $this->dispatch('notify', 'success', 'Berita berhasil dipublikasikan.');
        return redirect()->route('admin.berita.index');
    }

    public function render()
    {
        return view('livewire.admin.berita.create')
            ->layout('layouts.app', ['header' => 'Tulis Berita Baru']);
    }
}