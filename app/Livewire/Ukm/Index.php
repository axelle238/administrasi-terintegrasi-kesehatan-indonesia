<?php

namespace App\Livewire\Ukm;

use App\Models\KegiatanUkm;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nama_kegiatan, $tanggal_kegiatan, $lokasi, $penanggung_jawab, $jumlah_peserta, $hasil_kegiatan;
    public $isOpen = false;

    protected $rules = [
        'nama_kegiatan' => 'required|string',
        'tanggal_kegiatan' => 'required|date',
        'lokasi' => 'required|string',
        'penanggung_jawab' => 'required|string',
        'jumlah_peserta' => 'required|integer',
        'hasil_kegiatan' => 'nullable|string',
    ];

    public function create()
    {
        $this->reset();
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();
        KegiatanUkm::create([
            'nama_kegiatan' => $this->nama_kegiatan,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'lokasi' => $this->lokasi,
            'penanggung_jawab' => $this->penanggung_jawab,
            'jumlah_peserta' => $this->jumlah_peserta,
            'hasil_kegiatan' => $this->hasil_kegiatan,
        ]);
        $this->dispatch('notify', 'success', 'Kegiatan UKM disimpan.');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.ukm.index', [
            'kegiatans' => KegiatanUkm::latest()->paginate(10)
        ])->layout('layouts.app', ['header' => 'Upaya Kesehatan Masyarakat (UKM)']);
    }
}
