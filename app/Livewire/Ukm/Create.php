<?php

namespace App\Livewire\Ukm;

use App\Models\KegiatanUkm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nama_kegiatan;
    public $jenis_kegiatan;
    public $tanggal_kegiatan;
    public $lokasi;
    public $jumlah_peserta;
    public $deskripsi;
    public $file_laporan;

    protected $rules = [
        'nama_kegiatan' => 'required|string|max:255',
        'jenis_kegiatan' => 'required|string',
        'tanggal_kegiatan' => 'required|date',
        'lokasi' => 'required|string',
        'jumlah_peserta' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'file_laporan' => 'nullable|file|max:10240', // 10MB
    ];

    public function mount()
    {
        $this->tanggal_kegiatan = date('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->file_laporan) {
            $path = $this->file_laporan->store('ukm_laporan', 'public');
        }

        KegiatanUkm::create([
            'nama_kegiatan' => $this->nama_kegiatan,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'lokasi' => $this->lokasi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'deskripsi' => $this->deskripsi,
            'file_laporan' => $path,
            'user_id' => auth()->id(),
        ]);

        $this->dispatch('notify', 'success', 'Kegiatan UKM berhasil dicatat.');
        return $this->redirect(route('ukm.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.ukm.create')->layout('layouts.app', ['header' => 'Catat Kegiatan UKM']);
    }
}
