<?php

namespace App\Livewire\Surat\Disposisi;

use App\Models\Surat;
use App\Models\DisposisiSurat;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Manage extends Component
{
    public Surat $surat;
    public $penerima_id;
    public $catatan;
    public $sifat = 'Biasa';
    public $batas_waktu;

    protected $rules = [
        'penerima_id' => 'required|exists:users,id',
        'catatan' => 'required|string',
        'sifat' => 'required|in:Biasa,Penting,Segera,Rahasia',
        'batas_waktu' => 'nullable|date',
    ];

    public function mount(Surat $surat)
    {
        $this->surat = $surat;
    }

    public function save()
    {
        $this->validate();

        DisposisiSurat::create([
            'surat_id' => $this->surat->id,
            'pengirim_id' => Auth::id(),
            'penerima_id' => $this->penerima_id,
            'catatan' => $this->catatan,
            'sifat' => $this->sifat,
            'batas_waktu' => $this->batas_waktu,
            'status' => 'Baru',
        ]);

        $this->reset(['penerima_id', 'catatan', 'sifat', 'batas_waktu']);
        $this->dispatch('notify', 'success', 'Disposisi berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $disposisi = DisposisiSurat::find($id);
        if ($disposisi) {
            $disposisi->delete();
            $this->dispatch('notify', 'success', 'Disposisi dihapus.');
        }
    }

    public function render()
    {
        $disposisiList = DisposisiSurat::with(['pengirim', 'penerima'])
            ->where('surat_id', $this->surat->id)
            ->latest()
            ->get();
            
        $users = User::where('id', '!=', Auth::id())->get(); // List user selain diri sendiri

        return view('livewire.surat.disposisi.manage', compact('disposisiList', 'users'))
            ->layout('layouts.app', ['header' => 'Kelola Disposisi Surat']);
    }
}