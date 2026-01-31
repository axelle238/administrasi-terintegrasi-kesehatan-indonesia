<?php

namespace App\Livewire\Kepegawaian\Pelatihan;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\RiwayatPelatihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $nama_pelatihan, $penyelenggara, $tanggal_mulai, $tanggal_selesai, $durasi_jam;
    public $nomor_sertifikat, $file_sertifikat;
    public $isOpen = false;

    protected $rules = [
        'nama_pelatihan' => 'required|string|max:255',
        'penyelenggara' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'durasi_jam' => 'required|integer|min:1',
        'nomor_sertifikat' => 'nullable|string',
        'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ];

    public function create()
    {
        $this->reset();
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->file_sertifikat) {
            $path = $this->file_sertifikat->store('sertifikat-pelatihan', 'public');
        }

        RiwayatPelatihan::create([
            'user_id' => Auth::id(),
            'nama_pelatihan' => $this->nama_pelatihan,
            'penyelenggara' => $this->penyelenggara,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'durasi_jam' => $this->durasi_jam,
            'nomor_sertifikat' => $this->nomor_sertifikat,
            'file_sertifikat' => $path,
            'status' => 'Selesai'
        ]);

        $this->dispatch('notify', 'success', 'Data pelatihan berhasil disimpan.');
        $this->isOpen = false;
        $this->reset();
    }

    public function delete($id)
    {
        $item = RiwayatPelatihan::where('user_id', Auth::id())->findOrFail($id);
        if ($item->file_sertifikat) {
            Storage::disk('public')->delete($item->file_sertifikat);
        }
        $item->delete();
        $this->dispatch('notify', 'success', 'Data dihapus.');
    }

    public function render()
    {
        $pelatihans = RiwayatPelatihan::where('user_id', Auth::id())
            ->latest('tanggal_selesai')
            ->paginate(10);

        return view('livewire.kepegawaian.pelatihan.index', [
            'pelatihans' => $pelatihans
        ])->layout('layouts.app', ['header' => 'Pengembangan Kompetensi']);
    }
}