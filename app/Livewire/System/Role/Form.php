<?php

namespace App\Livewire\System\Role;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permission;
use App\Services\PermissionDiscoveryService;
use Illuminate\Support\Str;

class Form extends Component
{
    public $roleId;
    public $name;
    public $selectedPermissions = [];
    public $groupedPermissions = [];

    // Jika ada ID, berarti mode Edit
    public function mount($id = null)
    {
        if ($id) {
            $this->roleId = $id;
            $role = Role::with('permissions')->findOrFail($id);
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('id')->map(fn($id) => (string)$id)->toArray();
        }

        $this->loadPermissions();
    }

    public function loadPermissions()
    {
        // Ambil semua permission, dikelompokkan berdasarkan group_name
        $permissions = Permission::orderBy('group_name')->orderBy('name')->get();
        $this->groupedPermissions = $permissions->groupBy('group_name');
    }

    public function syncPermissions()
    {
        // Panggil Service Auto Discovery
        $service = new PermissionDiscoveryService();
        $service->discover();
        
        // Reload data
        $this->loadPermissions();
        $this->dispatch('notify', 'success', 'Daftar fitur dan fungsi berhasil diperbarui dari sistem!');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->roleId,
        ]);

        if ($this->roleId) {
            $role = Role::find($this->roleId);
            $role->update(['name' => $this->name]);
        } else {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web'
            ]);
        }

        // Sync Permissions
        $role->permissions()->sync($this->selectedPermissions);

        return redirect()->route('system.role.index')->with('success', 'Role dan Hak Akses berhasil disimpan.');
    }

    public function toggleGroup($groupName)
    {
        // Fitur "Pilih Semua" per grup
        $permissionsInGroup = $this->groupedPermissions[$groupName]->pluck('id')->map(fn($id) => (string)$id)->toArray();
        
        $hasAll = !array_diff($permissionsInGroup, $this->selectedPermissions);

        if ($hasAll) {
            // Uncheck all
            $this->selectedPermissions = array_diff($this->selectedPermissions, $permissionsInGroup);
        } else {
            // Check all
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $permissionsInGroup));
        }
    }

    public function render()
    {
        return view('livewire.system.role.form')->layout('layouts.app', ['header' => $this->roleId ? 'Edit Role Akses' : 'Buat Role Baru']);
    }
}
