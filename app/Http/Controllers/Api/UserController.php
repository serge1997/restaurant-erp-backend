<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Restaurant;
use App\Models\User;

class UserController extends BaseApiController
{
    
    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\User\UseCases\UserListUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\User\UseCases\UserListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of Users", $result);
    }

    public function show(User $user)
    {
        /**  @var \App\Modules\User\UseCases\UserListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\User\UseCases\UserListUseCase::class);
        $result = $useCase->listById($user);
        return $this->apiResponse("showing a user", $result);
    }

    public function store(UserCreateRequest $request)
    {
        /**  @var \App\Modules\User\UseCases\UserCreateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\User\UseCases\UserCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "usuario criado com successo", status: 201);
    }

    public function update(UserUpdateRequest $request)
    {
        /**  @var \App\Modules\User\UseCases\UserUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\User\UseCases\UserUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "usuario alterado com successo", status: 200);
    }

    public function switchRestaurant(Restaurant $restaurant)
    {
        /**  @var \App\Modules\User\UseCases\UserUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\User\UseCases\UserUpdateUseCase::class);
        $response = $useCase->switchRestaurant($restaurant);
        return $this->apiResponse(message: "ambiente de unidade trocado com successo", status: 200, data: $response);
    }
}
