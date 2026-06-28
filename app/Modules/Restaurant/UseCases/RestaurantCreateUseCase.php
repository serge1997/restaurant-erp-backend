<?php
namespace App\Modules\Restaurant\UseCases;

use App\Http\Requests\Restaurant\RestaurantCreateRequest;
use App\Modules\Restaurant\Repository\RestaurantRepository;

final class RestaurantCreateUseCase extends \App\Foundation\Base\BaseUseCase
{
    public function __construct(
        private readonly RestaurantRepository $restaurantRepository
    ){}

    public function execute(RestaurantCreateRequest $request)
    {
        $payload = $request->validated();
        if ($payload["logo"] instanceof \Illuminate\Http\UploadedFile){
            $extension = $payload["logo"]->getClientOriginalExtension();
            $avatarName = md5($payload["logo"]->getClientOriginalName() . strtotime("now")).".". $extension;
            $this->cropped_image($payload["logo"], 400, 200)
                ->save(storage_path("app/public/restaurants/logos/{$avatarName}"));
                
            $payload['logo'] = $avatarName;
        }
        $this->restaurantRepository->save($payload);
    }
}