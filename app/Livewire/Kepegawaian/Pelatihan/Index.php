<?php

namespace App\Livewire\Kepegawaian\Pelatihan;

use App\Models\RiwayatPelatihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $nama_pelatihan;
    public $penyelenggara;
    public $lokasi;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $jumlah_jam;
    public $nomor_sertifikat;
    public $file_sertifikat;

    public $isOpen = false;

    public function create()
    {
        $this->reset(['nama_pelatihan', 'penyelenggara', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'jumlah_jam', 'nomor_sertifikat', 'file_sertifikat']);
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'nama_pelatihan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB Max
        ]);

        $path = $this->file_sertifikat->store('sertifikat-pelatihan', 'public');

        RiwayatPelatihan::create([
            'user_id' => Auth::id(),
            'nama_pelatihan' => $this->nama_pelatihan,
            'penyelenggara' => $this->penyelenggara,
            'lokasi' => $this->lokasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'jumlah_jam' => $this->jumlah_jam ?? 0,
            'nomor_sertifikat' => $this->nomor_sertifikat,
            'file_sertifikat' => $path,
            'status_validasi' => 'Pending'
        ]);

        $this->dispatch('notify', 'success', 'Sertifikat berhasil diunggah.');
        $this->isOpen = false;
    }

    public function delete($id)
    {
        $data = RiwayatPelatihan::where('user_id', Auth::id())->find($id);
        if ($data) {
            Storage::disk('public')->delete($data->file_sertifikat);
            $data->delete();
            $this->dispatch('notify', 'success', 'Data pelatihan dihapus.');
        }
    }

    public function render()
    {
        $pelatihans = RiwayatPelatihan::where('user_id', Auth::id())
            ->latest('tanggal_mulai')
            ->get();

        return view('livewire.kepegawaian.pelatihan.index', [
            'pelatihans' => $pelatihans
        ])->layout('layouts.app', ['header' => 'Pengembangan Kompetensi & Sertifikat']);
    }
}
