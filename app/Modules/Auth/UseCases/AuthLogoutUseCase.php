<?php
namespace App\Modules\Auth\UseCases;

use App\Modules\User\Infra\UserRepository;
use Illuminate\Support\Facades\Cache;

final class AuthLogoutUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ){}
    public function execute()
    {
        $this->userRepository->auth->tokens()->delete();
        $this->userRepository->auth->update([
            'switch_restaurant_id'  => null
        ]);
        Cache::forget(sprintf("%s_%d_%s", "user", $this->userRepository->auth->id, "permissions"));
    }
}