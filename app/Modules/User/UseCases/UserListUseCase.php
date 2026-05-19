<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Infra\UserRepository;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\User\UserFormResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;

final class UserListUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(PaginateRequest $paginate)
    {
        return UserResource::collection($this->repository->findAll($paginate));
    }

    public function listById(User $user)
    {
        return new UserFormResource($user);
    }
}