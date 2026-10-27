<?php
namespace App\Modules\User\UseCases;

use App\Http\Resources\Restaurant\RestaurantResource;
use App\Modules\User\Infra\UserRepository;
use App\Modules\User\Exceptions\UserException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Permission;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

final class UserUpdateUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(UserUpdateRequest $request)
    {
        $payload = $request->validated();
        /** @var \App\Models\User $user */
        $user = $this->repository->find($payload['id']);
        if (!$user) {
            throw UserException::userNotFound();
        }
        $user->giveRoles($payload['roles']);
        DB::transaction(function() use($payload, $user) {
            $this->repository->update($user, $payload);
            unset($payload['address']['state']);
            unset($payload['address']['city']);
            $payload['address']['model'] = \App\Models\User::class;
            $user->address()->updateOrCreate(
                [
                    'model'     => \App\Models\User::class, 
                    'model_id'  => $user
                ],
                $payload['address']
            );
            $roles = $user->roles()->whereNotIn('id', $payload['roles'])->get();
            if($roles->toArray() != []){
                $user->removeRole($roles);
            }
            $permissions = [];
            foreach($payload['permissions'] as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    continue;
                }
                $permissions[] = $permission;
            }
            if($permissions != []) {
                $permissionsModels = Permission::whereIn('name', $permissions)->get();
                $user->givePermissionTo($permissionsModels);
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

    public function switchRestaurant(Restaurant $restaurant)
    {
        if (!$this->repository->auth) {
            throw new UnauthorizedException();
        }
        if(!$restaurant->sameChainWith($this->repository->auth)){
            throw new UnauthorizedException();
        }
        $this->repository->auth->switch_restaurant_id = $restaurant->id;
        $this->repository->update($this->repository->auth, ['switch_restaurant_id' => $restaurant->id]);
        return new RestaurantResource($restaurant);
    }
}