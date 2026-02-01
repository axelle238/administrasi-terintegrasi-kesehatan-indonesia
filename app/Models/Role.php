<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke Permissions (Many to Many)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    /**
     * Relasi ke User (via model_has_roles polymorphic)
     * Note: Karena kita pakai custom table 'model_has_roles' yang mirip Spatie
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles');
    }
    
    /**
     * Helper: Cek apakah role punya permission tertentu
     */
    public function hasPermissionTo($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
    
    /**
     * Helper: Sync permission
     */
    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }
}