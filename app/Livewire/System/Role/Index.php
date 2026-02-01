<?php

namespace App\Livewire\System\Role;

use Livewire\Component;
use App\Models\Role;
use App\Services\PermissionDiscoveryService;

class Index extends Component
{
    public function mount()
    {
        // Auto-scan permission saat pertama kali admin masuk ke halaman ini agar tidak kosong
        // (Optimistic check)
        if (\App\Models\Permission::count() === 0) {
            (new PermissionDiscoveryService())->discover();
        }
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deleting super-admin if needed, but for now allow dynamic management
        if ($role->name === 'admin' || $role->name === 'Super Admin') {
            $this->dispatch('notify', 'error', 'Role Administrator Utama tidak dapat dihapus.');
            return;
        }

        $role->delete();
        $this->dispatch('notify', 'success', 'Role berhasil dihapus.');
    }

    public function render()
    {
        $roles = Role::withCount('users', 'permissions')->latest()->get();

        return view('livewire.system.role.index', [
            'roles' => $roles
        ])->layout('layouts.app', ['header' => 'Manajemen Hak Akses & Peran']);
    }
}
