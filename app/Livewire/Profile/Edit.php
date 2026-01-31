<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;
    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    // Pegawai Data
    public $pegawai;
    public $no_telepon;
    public $alamat;
    public $kontak_darurat_nama;
    public $kontak_darurat_telp;
    public $foto_profil;
    public $new_foto_profil;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->pegawai = Pegawai::where('user_id', $this->user->id)->first();
        if ($this->pegawai) {
            $this->no_telepon = $this->pegawai->no_telepon;
            $this->alamat = $this->pegawai->alamat;
            $this->kontak_darurat_nama = $this->pegawai->kontak_darurat_nama;
            $this->kontak_darurat_telp = $this->pegawai->kontak_darurat_telp;
            $this->foto_profil = $this->pegawai->foto_profil;
        }
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'kontak_darurat_nama' => ['nullable', 'string'],
            'kontak_darurat_telp' => ['nullable', 'string'],
            'new_foto_profil' => ['nullable', 'image', 'max:1024'],
        ]);

        $this->user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->user->isDirty('email')) {
            $this->user->email_verified_at = null;
        }

        $this->user->save();

        // Update Pegawai Data
        $pegawaiData = [
            'no_telepon' => $this->no_telepon,
            'alamat' => $this->alamat,
            'kontak_darurat_nama' => $this->kontak_darurat_nama,
            'kontak_darurat_telp' => $this->kontak_darurat_telp,
        ];

        if ($this->new_foto_profil) {
            $path = $this->new_foto_profil->store('foto-profil', 'public');
            $pegawaiData['foto_profil'] = $path;
        }

        Pegawai::updateOrCreate(
            ['user_id' => $this->user->id],
            $pegawaiData
        );

        $this->dispatch('notify', 'success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->dispatch('notify', 'success', 'Kata sandi berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.profile.edit')->layout('layouts.app', ['header' => 'Profil Saya']);
    }
}