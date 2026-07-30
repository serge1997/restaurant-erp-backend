<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Models\PreRegistration;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;

final class PreRegistrationRegenerateConfirmTokenUseCase
{

    public function __construct(
        private PreRegistrationRepository $preRegistrationRepository
    ){}

    public function execute(PreRegistration $preRegistration)
    {
        if($preRegistration->confirmationTokenIsExpired()){
            $preRegistration = $this->preRegistrationRepository->update($preRegistration, [
                'comfirmation_token'            => $preRegistration->generateRegistrationConfirmationToken(),
                'confirmation_token_expired_at' => now()->addHours((int)config('services.registration_token_expired_in'))
            ]);
            //send email
        }
    }
}