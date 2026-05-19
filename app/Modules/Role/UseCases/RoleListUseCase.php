<?php
namespace App\Modules\Role\UseCases;

use App\Modules\Role\Infra\RoleRepository;
use App\Http\Resources\Role\RoleResource;
use App\Models\User;

final class RoleListUseCase
{
    public function __construct(
        private readonly RoleRepository $repository
    ) {}

    public function execute()
    {
        return RoleResource::collection($this->repository->load());
    }

    public function listByUser(User $user)
    {
        return RoleResource::collection($user->roles);
    }
}