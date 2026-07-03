<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Modules\Address\UseCases\AddressOfCepUseCase;

class AddressController extends BaseApiController
{
    public function cep(string $cep)
    {
        /** @var AddressOfCepUseCase $useCase */
        $useCase = $this->container->get(AddressOfCepUseCase::class);
        $address = $useCase->execute($cep);
        return $this->apiResponse("cep address", $address);
    }
}
