<?php
namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{

    public function loadPermissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id')
        ->whereNotIn('role_has_permissions.permission_id', function($query){
            $query->from('model_has_permissions')->select('permission_id')->where('granted', false);
        });
    }
}