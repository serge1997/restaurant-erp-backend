<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\Alert\AlertCreateRequest;
use App\Http\Requests\Alert\AlertUpdateRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Alert;

class AlertController extends BaseApiController
{
    
    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Alert\UseCases\AlertListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Alert\UseCases\AlertListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of alerts", $result);
    }

    public function show(Alert $alert)
    {
        /**  @var \App\Modules\Alert\UseCases\AlertListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Alert\UseCases\AlertListUseCase::class);
        $result = $useCase->listById($alert);
        return $this->apiResponse("showing a room", $result);
    }

    public function store(AlertCreateRequest $request)
    {
        /**  @var \App\Modules\Alert\UseCases\AlertCreateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Alert\UseCases\AlertCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "alerta criada com successo", status: 201);
    }

    public function update(AlertUpdateRequest $request)
    {
        /**  @var \App\Modules\Alert\UseCases\AlertUpdateUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Alert\UseCases\AlertUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "alerta alterada com successo", status: 200);
    }

    public function delete(int $id)
    {
        /**  @var \App\Modules\Alert\UseCases\AlertDeleteUseCase $useCase  */
        $useCase = $this->container->get(\App\Modules\Alert\UseCases\AlertDeleteUseCase::class);
        $useCase->execute($id);
        return $this->apiResponse(message: "alerta removida com successo", status: 200);
    }
}
