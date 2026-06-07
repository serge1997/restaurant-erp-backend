<?php
namespace App\Modules\Auth\UseCases;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Resources\RouteGroup\RouteGroupResource;
use App\Http\Resources\User\UserResource;
use App\Models\RouteGroup;
use App\Models\User;
use App\Modules\User\Infra\UserRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

final class AuthLoginUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ){}

    public function execute(AuthLoginRequest $request)
    {
        $payload = $request->validated();
        $user = $this->userRepository->findFirstBy(["username"], [$payload['username']]);
        if (!$user || !Hash::check($request->password, $user->password)){
            throw new UnauthorizedException("usuario ou senha invalido", 401);
        }
        $expireAt = Carbon::now()->addMinutes(60);
        return [
            "token" => $user->createToken('browser', ['*'], $expireAt)->plainTextToken,
            "menu"  => $this->loadMenu($user),
            'auth'  => new UserResource($user)
        ];
    }

    private function loadMenu(User $user)
    {
        $results = [];
        $allPermissions = array_merge($user->permissions->toArray(),...$user->rolesPermissions());
        $routesGroupIds = array_column($allPermissions, 'route_group_id');
        $routesGroupes = RouteGroup::whereIn('id', $routesGroupIds)->get();
        $groupes = RouteGroupResource::collection($routesGroupes);
        foreach ($groupes as $group) {
            $modulesIds = array_column($results, 'id');
            if (in_array($group->module->id, $modulesIds)){
                if (!$group->permissions){
                    continue;
                }
                $index = array_search($group->module->id, array_column($results, 'id'));
                $permissions = [...$results[$index]['permissions'], ...$group->permissions];
                $results[$index]['permissions'] = $permissions;
                continue;
            }
            if ($group->permissions){
                $results[] = [
                    'id'   => $group->module->id,
                    'name'   => $group->name,
                    'module'    => $group->module,
                    'permissions'   => $group->permissions ?? []
                ];
            }
        }
        return $results;
    }
}