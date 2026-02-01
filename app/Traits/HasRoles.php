<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRoles
{
    /**
     * Relasi ke Role.
     */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    /**
     * Helper: Ambil semua permission user via role.
     */
    public function allPermissions()
    {
        // Load roles beserta permission-nya
        $this->loadMissing('roles.permissions');

        // Flatten permissions
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->unique('id');
    }

    /**
     * Assign Role ke User.
     */
    public function assignRole($roleName)
    {
        $role = Role::firstOrCreate(['name' => $roleName]);
        $this->roles()->syncWithoutDetaching([$role->id]);
        return $this;
    }

    /**
     * Hapus Role dari User.
     */
    public function removeRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->roles()->detach($role->id);
        }
        return $this;
    }

    /**
     * Cek apakah user punya role tertentu.
     */
    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }

    /**
     * Cek apakah user punya permission (via Role).
     */
    public function hasPermissionTo($permissionName)
    {
        return $this->allPermissions()->contains('name', $permissionName);
    }
}