<?php
namespace App\Modules\Restaurant\UseCases;

use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Modules\Restaurant\Repository\RestaurantRepository;

final class RestaurantCreateUseCase
{
    public function __construct(
        private readonly RestaurantRepository $restaurantRepository
    ){}

    public function execute(RestaurantCreateRequest $request)
    {
        $this->restaurantRepository->save($request->validated());
    }
}