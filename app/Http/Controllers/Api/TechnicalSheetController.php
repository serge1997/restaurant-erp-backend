<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\TechnicalSheet\TechnicalSheetCreateRequest;
use App\Http\Requests\TechnicalSheet\TechnicalSheetUpdateRequest;
use App\Models\MenuItem;
use App\Modules\TechnicalSheet\UseCases\TechnicalSheetCreateUseCase;
use App\Modules\TechnicalSheet\UseCases\TechnicalSheetUpdateUseCase;
use App\Modules\TechnicalSheet\UseCases\TecnhicalSheetListUseCase;
use Illuminate\Http\JsonResponse;

class TechnicalSheetController extends BaseApiController
{

    public function store(TechnicalSheetCreateRequest $request): JsonResponse
    {
        /** @var TechnicalSheetCreateUseCase $useCase */
        $useCase = $this->container->get(TechnicalSheetCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("ficha técnica criada com successo !");
    }

    public function listByMenuItem(MenuItem $menuItem): JsonResponse
    {
        /** @var TecnhicalSheetListUseCase $useCase */
        $useCase = $this->container->get(TecnhicalSheetListUseCase::class);
        $response = $useCase->listByMenuItem($menuItem);
        return $this->apiResponse("list of technical sheet of item.", $response);
    }

    public function update(TechnicalSheetUpdateRequest $request): JsonResponse
    {
        /** @var TechnicalSheetUpdateUseCase $useCase */
        $useCase = $this->container->get(TechnicalSheetUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse("ficha técnica alterada com successo!.");
    }
}
