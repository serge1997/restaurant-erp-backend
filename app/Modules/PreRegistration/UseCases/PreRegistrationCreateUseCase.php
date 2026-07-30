<?php
namespace App\Modules\PreRegistration\UseCases;

use App\Http\Requests\PreRegistration\PreRegistrationCreateRequest;
use App\Models\PreRegistration;
use App\Modules\PreRegistration\Exception\PreRegistrationException;
use App\Modules\PreRegistration\Infra\Repository\PreRegistrationRepository;
use Illuminate\Support\Facades\DB;

final class PreRegistrationCreateUseCase
{

    public function __construct(
        private readonly PreRegistrationRepository $preRegistrationRepository
    ){}

    public function execute(PreRegistrationCreateRequest $request)
    {
        $payload = $request->validated();
        $existsByEmail = $this->preRegistrationRepository->existBy("email", $payload["email"]);
        if($existsByEmail){
            throw PreRegistrationException::existsByEmail();
        }
        $existsByCnpj = $this->preRegistrationRepository->existBy("cnpj", $request->cnpj());
        if($existsByCnpj){
            throw PreRegistrationException::existsByCnpj();
        }
        DB::transaction(function() use($payload, $request){
            $meta = [];
            $payload['confirmation_token']      = PreRegistration::generateRegistrationConfirmationToken();
            $payload['cnpj']                    = $request->cnpj();
            $payload['confirmation_token_expired_at']   = now()->addHours((int)config('services.registration_token_expired_in'));
            $payload['account_responsable_cpf'] = $request->accountResponsableCpf();
            $preRegistration = $this->preRegistrationRepository->save($payload);
            if ($preRegistration instanceof PreRegistration){
                $payload['address']['model'] = PreRegistration::class;
                $companyAddress = $preRegistration->addresses()->create($payload['address']);
                $meta[] = ['company_address' => $companyAddress->id];
                $responsableAddress = $payload['account_responsable_address'];
                if(!empty($responsableAddress['cep'])){
                    $responsableAddress['model']  = PreRegistration::class;
                    $responsableAddress = $preRegistration->addresses()->create($responsableAddress);
                    $meta[] = ['responsable_address' => $responsableAddress->id];
                }
                $this->preRegistrationRepository->update($preRegistration, ['meta'  => json_encode($meta)]);
            }
        });
    }
}