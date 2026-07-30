<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Http\Requests\PreRegistration\PreRegistrationConfirmRequest;
use App\Models\Address;
use App\Models\PreRegistration;
use App\Models\RestaurantChain;
use App\Models\User;
use App\Modules\Address\Infra\Repository\AddressRepository;
use App\Modules\PreRegistration\Exception\PreRegistrationException;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;
use App\Modules\RestaurantChain\Infra\Repository\RestaurantChainRepository;
use App\Modules\User\Infra\UserRepository;
use Illuminate\Support\Facades\DB;

final class PreRegistrationConfirmUseCase
{
    public function __construct(
        private readonly PreRegistrationRepository $preRegistrationRepository,
        private readonly RestaurantChainRepository $restaurantChainRepository,
        private readonly AddressRepository $addressRepository,
        private readonly UserRepository $userRepository
    ){}
    public function execute(PreRegistrationConfirmRequest $request)
    {
        $payload = $request->validated();
        $preRegistration = $this->preRegistrationRepository->find($payload["id"]);
        if ($preRegistration instanceof PreRegistration) {
            if($preRegistration->confirmationTokenIsExpired()){
                throw PreRegistrationException::tokenExpired();
            }
            DB::transaction(function() use($payload, $preRegistration){
                $asUser = $preRegistration->asUser();
                $asChain = $preRegistration->asCompany();
                $userAddress = $this->addressRepository->find($preRegistration->responsableAddressId());
                $chainAddress = $this->addressRepository->find($preRegistration->companyAddressId());
                $this->userRepository->save([
                    'password'  => bcrypt($payload['password']),
                    ...$asUser
                ]);
                $this->restaurantChainRepository->save($asChain);
                if($userAddress instanceof Address){
                    $this->addressRepository->update($userAddress, ['model' => User::class]);
                }
                if($chainAddress instanceof Address){
                    $this->addressRepository->update($chainAddress, ['model'    => RestaurantChain::class]);
                }
            });
        }
    }
}