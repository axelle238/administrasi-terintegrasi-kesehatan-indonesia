<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Pasien $pasien;
    
    public $nik;
    public $no_bpjs;
    public $nama_lengkap;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $no_telepon;
    public $golongan_darah;

    public function mount(Pasien $pasien)
    {
        $this->pasien = $pasien;
        $this->nik = $pasien->nik;
        $this->no_bpjs = $pasien->no_bpjs;
        $this->nama_lengkap = $pasien->nama_lengkap;
        $this->tempat_lahir = $pasien->tempat_lahir;
        $this->tanggal_lahir = $pasien->tanggal_lahir;
        $this->jenis_kelamin = $pasien->jenis_kelamin;
        $this->alamat = $pasien->alamat;
        $this->no_telepon = $pasien->no_telepon;
        $this->golongan_darah = $pasien->golongan_darah;
    }

    public function update()
    {
        $this->validate([
            'nik' => ['required', 'digits:16', Rule::unique('pasiens')->ignore($this->pasien->id)],
            'no_bpjs' => ['nullable', 'numeric', Rule::unique('pasiens')->ignore($this->pasien->id)],
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $this->pasien->update([
            'nik' => $this->nik,
            'no_bpjs' => $this->no_bpjs,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_telepon' => $this->no_telepon,
            'golongan_darah' => $this->golongan_darah,
        ]);

        $this->dispatch('notify', 'success', 'Data pasien berhasil diperbarui.');
        return $this->redirect(route('pasien.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pasien.edit')->layout('layouts.app', ['header' => 'Edit Data Pasien']);
    }
}