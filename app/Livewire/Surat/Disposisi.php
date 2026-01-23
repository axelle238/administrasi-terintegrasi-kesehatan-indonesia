<?php

namespace App\Livewire\Surat;

use App\Models\Surat;
use App\Models\User;
use App\Models\DisposisiSurat;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Disposisi extends Component
{
    public $suratId;
    public $isOpen = false;

    // Form Fields
    public $penerima_id;
    public $sifat_disposisi = 'Biasa';
    public $batas_waktu;
    public $instruksi;
    public $catatan;

    protected $listeners = ['openDisposisi' => 'open'];

    protected $rules = [
        'penerima_id' => 'required|exists:users,id',
        'sifat_disposisi' => 'required|string',
        'batas_waktu' => 'nullable|date',
        'instruksi' => 'required|string|min:5',
    ];

    public function open($suratId)
    {
        $this->suratId = $suratId;
        $this->isOpen = true;
        $this->reset(['penerima_id', 'instruksi', 'catatan']);
        $this->sifat_disposisi = 'Biasa';
        $this->batas_waktu = date('Y-m-d', strtotime('+3 days'));
    }

    public function save()
    {
        $this->validate();

        DisposisiSurat::create([
            'surat_id' => $this->suratId,
            'pengirim_id' => Auth::id(),
            'penerima_id' => $this->penerima_id,
            'sifat_disposisi' => $this->sifat_disposisi,
            'batas_waktu' => $this->batas_waktu,
            'instruksi' => $this->instruksi,
            'catatan' => $this->catatan,
            'status' => 'Belum Dibaca',
        ]);

        $this->dispatch('notify', 'success', 'Disposisi berhasil dikirim.');
        $this->isOpen = false;
        $this->dispatch('disposisiSent'); // Refresh parent component if needed
    }

    public function render()
    {
        // Ambil list user kecuali diri sendiri untuk tujuan disposisi
        $users = User::where('id', '!=', Auth::id())->orderBy('name')->get();

        return view('livewire.surat.disposisi', [
            'users' => $users
        ]);
    }
}
