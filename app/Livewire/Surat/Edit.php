<?php

namespace App\Livewire\Surat;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Surat $surat;
    public $nomor_surat;
    public $tanggal_surat;
    public $tanggal_diterima;
    public $pengirim;
    public $penerima;
    public $perihal;
    public $jenis_surat;
    public $file_surat;
    public $existingFile;
    
    // Disposisi
    public $disposisi;
    public $tujuan_disposisi;
    public $status_disposisi;

    public function mount(Surat $surat)
    {
        $this->surat = $surat;
        $this->nomor_surat = $surat->nomor_surat;
        $this->tanggal_surat = $surat->tanggal_surat;
        $this->tanggal_diterima = $surat->tanggal_diterima;
        $this->pengirim = $surat->pengirim;
        $this->penerima = $surat->penerima;
        $this->perihal = $surat->perihal;
        $this->jenis_surat = $surat->jenis_surat;
        $this->existingFile = $surat->file_path;
        $this->disposisi = $surat->disposisi;
        $this->tujuan_disposisi = $surat->tujuan_disposisi;
        $this->status_disposisi = $surat->status_disposisi;
    }

    public function update()
    {
        $this->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file|max:10240',
        ]);

        $path = $this->existingFile;
        if ($this->file_surat) {
            if ($this->existingFile) {
                Storage::disk('public')->delete($this->existingFile);
            }
            $path = $this->file_surat->store('surat', 'public');
        }

        $this->surat->update([
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_diterima' => $this->jenis_surat == 'Masuk' ? $this->tanggal_diterima : null,
            'pengirim' => $this->pengirim,
            'penerima' => $this->penerima,
            'perihal' => $this->perihal,
            'file_path' => $path,
            'disposisi' => $this->disposisi,
            'tujuan_disposisi' => $this->tujuan_disposisi,
            'status_disposisi' => $this->status_disposisi,
        ]);

        $this->dispatch('notify', 'success', 'Data surat diperbarui.');
        return $this->redirect(route('surat.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.surat.edit')->layout('layouts.app', ['header' => 'Edit Arsip Surat']);
    }
}