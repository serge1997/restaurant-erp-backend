<?php
namespace App\Modules\Restaurant\UseCases;

use App\Http\Requests\Restaurant\RestaurantUpdateRequest;
use App\Modules\Restaurant\Exceptions\RestaurantNotFoundExecption;
use App\Modules\Restaurant\Repository\RestaurantRepository;

final class RestaurantUpdateUseCase
{
    public function __construct(
        private readonly RestaurantRepository $repository
    ){}

    public function execute(RestaurantUpdateRequest $request)
    {
        $restaurant = $this->repository->find($request->id);
        if (!$restaurant) {
            throw new RestaurantNotFoundExecption;
        }
        $this->repository->update($restaurant, $request->validated());
    }
}