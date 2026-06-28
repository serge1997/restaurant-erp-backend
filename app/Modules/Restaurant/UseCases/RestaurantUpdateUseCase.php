<?php
namespace App\Modules\Restaurant\UseCases;

use App\Http\Requests\restaurant\RestaurantStoreFileRequest;
use App\Http\Requests\Restaurant\RestaurantUpdateRequest;
use App\Modules\Restaurant\Exceptions\RestaurantNotFoundExecption;
use App\Modules\Restaurant\Repository\RestaurantRepository;

final class RestaurantUpdateUseCase extends \App\Foundation\Base\BaseUseCase
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

    public function executeFile(RestaurantStoreFileRequest $request)
    {
        $payload = $request->validated();
        $restaurant = $this->repository->find($request->id);
        if (!$restaurant) {
            throw new RestaurantNotFoundExecption;
        }
        if ($payload["logo"] instanceof \Illuminate\Http\UploadedFile){
            $extension = $payload["logo"]->getClientOriginalExtension();
            $avatarName = md5($payload["logo"]->getClientOriginalName() . strtotime("now")).".". $extension;
            $this->cropped_image($payload["logo"], 400, 200)
                ->save(storage_path("app/public/restaurants/logos/{$avatarName}"));
                
            $payload['logo'] = $avatarName;
        }

        if (isset($payload["certificate"]) && $payload["certificate"] instanceof \Illuminate\Http\UploadedFile){
            $extension = $payload["certificate"]->getClientOriginalExtension();
            $avatarName = md5($payload["logo"]->getClientOriginalName() . strtotime("now")).".". $extension;
            $payload["certificate"]->storeAs(storage_path("app/public/restaurants/certificate/{$avatarName}"));
            $payload['logo'] = $avatarName;
        }
        $this->repository->update($restaurant, $payload);
    }
}