<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\Poli;

class Edit extends Component
{
    use WithFileUploads;

    public Pegawai $pegawai;
    
    // User fields
    public $name;
    public $email;
    public $password; // Optional on update
    public $role;

    // Pegawai fields
    public $nip;
    public $jabatan;
    public $poli_id;
    public $no_telepon;
    public $alamat;
    public $status_kepegawaian;
    public $tanggal_masuk;
    public $no_str;
    public $masa_berlaku_str;
    public $no_sip;
    public $masa_berlaku_sip;

    // File Uploads
    public $new_file_str;
    public $new_file_sip;
    public $new_file_ijazah;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
        
        // Load User Data
        $this->name = $pegawai->user->name;
        $this->email = $pegawai->user->email;
        $this->role = $pegawai->user->role;

        // Load Pegawai Data
        $this->nip = $pegawai->nip;
        $this->jabatan = $pegawai->jabatan;
        $this->poli_id = $pegawai->poli_id;
        $this->no_telepon = $pegawai->no_telepon;
        $this->alamat = $pegawai->alamat;
        $this->status_kepegawaian = $pegawai->status_kepegawaian;
        $this->tanggal_masuk = $pegawai->tanggal_masuk;
        $this->no_str = $pegawai->no_str;
        $this->masa_berlaku_str = $pegawai->masa_berlaku_str;
        $this->no_sip = $pegawai->no_sip;
        $this->masa_berlaku_sip = $pegawai->masa_berlaku_sip;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->pegawai->user_id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,dokter,apoteker,perawat,staf',
            'nip' => ['required', 'string', Rule::unique('pegawais', 'nip')->ignore($this->pegawai->id)],
            'jabatan' => 'required|string',
            'poli_id' => 'nullable|exists:polis,id',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'status_kepegawaian' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'no_str' => 'nullable|string',
            'masa_berlaku_str' => 'nullable|date',
            'no_sip' => 'nullable|string',
            'masa_berlaku_sip' => 'nullable|date',
            'new_file_str' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'new_file_sip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'new_file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Update User
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ];

            if (!empty($this->password)) {
                $userData['password'] = Hash::make($this->password);
            }

            $this->pegawai->user->update($userData);

            // Handle Files
            $updateData = [
                'nip' => $this->nip,
                'jabatan' => $this->jabatan,
                'poli_id' => $this->poli_id,
                'no_telepon' => $this->no_telepon,
                'alamat' => $this->alamat,
                'status_kepegawaian' => $this->status_kepegawaian,
                'tanggal_masuk' => $this->tanggal_masuk,
                'no_str' => $this->no_str,
                'masa_berlaku_str' => $this->masa_berlaku_str,
                'no_sip' => $this->no_sip,
                'masa_berlaku_sip' => $this->masa_berlaku_sip,
            ];

            if ($this->new_file_str) {
                $updateData['file_str'] = $this->new_file_str->store('documents/pegawai', 'public');
            }
            if ($this->new_file_sip) {
                $updateData['file_sip'] = $this->new_file_sip->store('documents/pegawai', 'public');
            }
            if ($this->new_file_ijazah) {
                $updateData['file_ijazah'] = $this->new_file_ijazah->store('documents/pegawai', 'public');
            }

            // Update Pegawai
            $this->pegawai->update($updateData);

            DB::commit();

            $this->dispatch('notify', 'success', 'Data pegawai berhasil diperbarui.');
            return $this->redirect(route('pegawai.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pegawai.edit', [
            'polis' => Poli::all()
        ])->layout('layouts.app', ['header' => 'Edit Data Pegawai']);
    }
}