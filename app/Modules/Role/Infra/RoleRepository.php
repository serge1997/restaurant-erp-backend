<?php
namespace App\Modules\Role\Infra;


use App\Foundation\Base\BaseRepository;
use App\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(
        private readonly Role $role
    ){}

    protected function eloquent(): Role
    {
        return new Role();
    }

    public function load()
    {
        return $this->role->query()->whereNot('name', 'super_admin')->get();
    }

    public function loadPermissions(Role $role)
    {
        return $role->permissions()->get();
    }
}