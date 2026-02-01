<?php

namespace App\Livewire\Pegawai\Tabs;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pegawai;
use App\Models\Kredensial;
use App\Models\DokumenPegawai;
use Illuminate\Support\Facades\Storage;

class Dokumen extends Component
{
    use WithFileUploads;

    public $pegawai;

    // Form Kredensial
    public $nama_dokumen;
    public $nomor_dokumen;
    public $tanggal_terbit;
    public $tanggal_berakhir;
    public $file_kredensial;

    // Form Dokumen Umum
    public $kategori_dokumen;
    public $file_dokumen_umum;
    public $keterangan_dokumen;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function saveKredensial()
    {
        $this->validate([
            'nama_dokumen' => 'required',
            'nomor_dokumen' => 'required',
            'tanggal_berakhir' => 'required|date',
            'file_kredensial' => 'required|file|max:2048', // 2MB
        ]);

        $path = $this->file_kredensial->store('kredensial', 'public');

        Kredensial::create([
            'pegawai_id' => $this->pegawai->id,
            'nama_dokumen' => $this->nama_dokumen,
            'nomor_dokumen' => $this->nomor_dokumen,
            'tanggal_terbit' => $this->tanggal_terbit ?? now(),
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'file_dokumen' => $path,
        ]);

        $this->reset(['nama_dokumen', 'nomor_dokumen', 'tanggal_terbit', 'tanggal_berakhir', 'file_kredensial']);
        session()->flash('message_kredensial', 'Kredensial berhasil disimpan.');
    }

    public function saveDokumen()
    {
        $this->validate([
            'kategori_dokumen' => 'required',
            'file_dokumen_umum' => 'required|file|max:2048',
        ]);

        $path = $this->file_dokumen_umum->store('dokumen_pegawai', 'public');

        DokumenPegawai::create([
            'pegawai_id' => $this->pegawai->id,
            'kategori' => $this->kategori_dokumen,
            'file_path' => $path,
            'keterangan' => $this->keterangan_dokumen
        ]);

        $this->reset(['kategori_dokumen', 'file_dokumen_umum', 'keterangan_dokumen']);
        session()->flash('message_dokumen', 'Dokumen berhasil diarsipkan.');
    }

    public function deleteKredensial($id)
    {
        Kredensial::find($id)->delete();
    }

    public function deleteDokumen($id)
    {
        DokumenPegawai::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.pegawai.tabs.dokumen', [
            'kredensials' => Kredensial::where('pegawai_id', $this->pegawai->id)->orderBy('tanggal_berakhir')->get(),
            'dokumens' => DokumenPegawai::where('pegawai_id', $this->pegawai->id)->latest()->get(),
        ]);
    }
}