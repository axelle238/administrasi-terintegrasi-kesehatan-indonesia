<?php

namespace App\Livewire\System\User;

use App\Models\User;
use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role;

    public function create()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'role']);
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // Don't fill password
        $this->isOpen = true;
    }

    public function save()
    {
        if ($this->userId) {
            // ... (Update logic)
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
                'role' => 'required|string',
                'password' => 'nullable|min:8',
            ]);

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ];
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            User::find($this->userId)->update($data);
            $this->dispatch('notify', 'success', 'User diperbarui.');
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'role' => 'required|string',
                'password' => 'required|min:8',
            ]);

            DB::transaction(function () {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'password' => Hash::make($this->password),
                ]);

                // Auto-create Pegawai Profile agar bisa Absen
                Pegawai::create([
                    'user_id' => $user->id,
                    'nip' => date('Ymd') . rand(1000, 9999), // Temporary NIP
                    'jabatan' => 'Pegawai Baru',
                    'status_kepegawaian' => 'Honor',
                    'alamat' => '-',
                    'no_telepon' => '-',
                    'tanggal_masuk' => now()
                ]);
            });

            $this->dispatch('notify', 'success', 'User & Profil Pegawai ditambahkan.');
        }

        $this->isOpen = false;
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            $this->dispatch('notify', 'error', 'Tidak dapat menghapus diri sendiri.');
            return;
        }
        User::find($id)->delete();
        $this->dispatch('notify', 'success', 'User dihapus.');
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.system.user.index', [
            'users' => $users
        ])->layout('layouts.app', ['header' => 'Manajemen User (System Internal)']);
    }
}