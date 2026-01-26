<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Poli;

class Create extends Component
{
    use WithFileUploads;

    // User fields
    public $name;
    public $email;
    public $password;
    public $role = 'staf';

    // Pegawai fields
    public $nip;
    public $jabatan;
    public $poli_id; // Added Poli Selection
    public $no_telepon;
    public $alamat;
    public $status_kepegawaian = 'Kontrak';
    public $tanggal_masuk;
    public $no_str;
    public $masa_berlaku_str;
    public $no_sip;
    public $masa_berlaku_sip;
    
    // File Uploads
    public $file_str;
    public $file_sip;
    public $file_ijazah;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:admin,dokter,apoteker,perawat,staf',
        'nip' => 'required|string|unique:pegawais,nip',
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
        'file_str' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_sip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // 1. Create User Account
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);
            
            // Handle Files
            $pathStr = $this->file_str ? $this->file_str->store('documents/pegawai', 'public') : null;
            $pathSip = $this->file_sip ? $this->file_sip->store('documents/pegawai', 'public') : null;
            $pathIjazah = $this->file_ijazah ? $this->file_ijazah->store('documents/pegawai', 'public') : null;

            // 2. Create Pegawai Profile
            Pegawai::create([
                'user_id' => $user->id,
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
                'file_str' => $pathStr,
                'file_sip' => $pathSip,
                'file_ijazah' => $pathIjazah,
            ]);

            DB::commit();

            $this->dispatch('notify', 'success', 'Data pegawai & akun berhasil dibuat.');
            return $this->redirect(route('pegawai.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal menambahkan pegawai: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pegawai.create', [
            'polis' => Poli::all()
        ])->layout('layouts.app', ['header' => 'Tambah Pegawai Baru']);
    }
}