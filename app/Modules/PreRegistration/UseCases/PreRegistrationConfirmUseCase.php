<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Http\Requests\PreRegistration\PreRegistrationConfirmRequest;
use App\Models\Address;
use App\Models\PreRegistration;
use App\Models\Restaurant;
use App\Models\RestaurantChain;
use App\Models\User;
use App\Modules\Address\Infra\Repository\AddressRepository;
use App\Modules\PreRegistration\Exception\PreRegistrationException;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;
use Illuminate\Support\Facades\DB;

final class PreRegistrationConfirmUseCase
{
    public function __construct(
        private readonly PreRegistrationRepository $preRegistrationRepository,
        private readonly AddressRepository $addressRepository
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
                $asRestaurant = $preRegistration->asRestaurant();
                $userAddress = $this->addressRepository->find($preRegistration->responsableAddressId());
                $chainAddress = $this->addressRepository->find($preRegistration->companyAddressId());
                $asChain->save();
                $asRestaurant->chain_id = $asChain->id;
                $asRestaurant->save();
                $asUser->restaurant_id = $asRestaurant->id;
                $asUser->password = bcrypt($payload['password']);
                $asUser->save();
                if($userAddress instanceof Address){
                    $this->addressRepository->update($userAddress, ['model' => User::class]);
                }

                if($chainAddress instanceof Address){
                    $this->addressRepository->update($chainAddress, ['model'  => RestaurantChain::class]);
                    $restaurantAddress = $chainAddress;
                    $restaurantAddress->fill([
                        'model' => Restaurant::class,
                        'model_id' => $asRestaurant->id
                    ]);
                    $restaurantAddress->id = null;
                    $this->addressRepository->save($restaurantAddress->toArray());
                }
                $this->preRegistrationRepository->update($preRegistration, ['is_confirmed' => true]);
            });
        }
    }
}