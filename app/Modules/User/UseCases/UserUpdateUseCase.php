<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Infra\UserRepository;
use App\Modules\User\Exceptions\UserException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class UserUpdateUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(UserUpdateRequest $request)
    {
        $payload = $request->validated();
        $user = $this->repository->find($payload['id']);
        if (!$user) {
            throw UserException::userNotFound();
        }
        $user->assignRole($payload['roles']);
        DB::transaction(function() use($payload, $user) {
            $this->repository->update($user, $payload);
            $user->address()->update($payload['address']);
            $roles = $user->roles()->whereNotIn('id', $payload['roles'])->pluck('name');
            if($roles->toArray() != []){
                $user->removeRole($roles);
            }
            foreach($payload['permissions'] as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    continue;
                }
                $user->givePermissionTo($permission);
            }
            $allPermissions = array_merge($user->permissions->toArray(),...$user->rolesPermissions());
            $allPermissionsNames = array_column($allPermissions, 'name');
            foreach($allPermissionsNames as $permission){
                $getNamePermission = array_find($allPermissions, fn($pem) => $pem['name'] == $permission);
                if ($user->hasPermissionTo($permission) && !in_array($permission, $payload['permissions'])){
                    $user->grantedPermissions((int)$getNamePermission['id'], false);
                    continue;
                }
                if (!$user->hasPermissionTo($permission)){
                    $user->grantedPermissions((int)$getNamePermission['id'], true);
                }
            }

            $user->removeAllGranted();
        });
    }
}