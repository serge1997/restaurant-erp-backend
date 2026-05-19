<?php
namespace App\Modules\User\UseCases;

use App\Http\Requests\User\UserCreateRequest;
use App\Models\User;
use App\Modules\Address\Infra\AddressRepository;
use App\Modules\Role\Infra\RoleRepository;
use App\Modules\User\Infra\UserRepository;
use Illuminate\Support\Facades\DB;

final class UserCreateUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AddressRepository $addressRepository,
        private RoleRepository $roleRepository
    ){}

    public function execute(UserCreateRequest $request)
    {
        $payload = $request->validated();
        $payload["password"] = bcrypt("12345678");
        DB::transaction(function() use($payload){
            $user = $this->userRepository->save($payload);
            $user->address()->create([
                ...$payload["address"],
                "model" => User::class
            ]);
            $user->assignRole($payload['roles']);
        });
    }
}