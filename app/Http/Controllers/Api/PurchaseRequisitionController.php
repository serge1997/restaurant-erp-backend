<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\PurchaseRequisition\PurchaseRequisitionCreateRequest;
use App\Http\Requests\PurchaseRequisition\PurchaseRequisitionUpdateRequest;
use App\Models\PurchaseRequisition;
use App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionDocumentPdfUseCase;

class PurchaseRequisitionController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of purchase requisitions", $result);
    }

    public function show(PurchaseRequisition $purchaseRequisition)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase::class);
        $result = $useCase->listById($purchaseRequisition);
        return $this->apiResponse("showing a purchase requisitions", $result);
    }

    public function store(PurchaseRequisitionCreateRequest $request)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "requisiçao de compra criado com successo", status: 201);
    }

    public function update(PurchaseRequisitionUpdateRequest $request)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "requisiçao de compra alterado com successo", status: 200);
    }

    public function delete(PurchaseRequisition $purchaseRequisition)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionDeleteUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionDeleteUseCase::class);
        $useCase->execute($purchaseRequisition);
        return $this->apiResponse(message: "requisiçao de compra deletada com successo", status: 200);
    }

    public function attacheStatus(PurchaseRequisition $purchaseRequisition, int $status)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionUpdateUseCase::class);
        $message = $useCase->attacheStatus($purchaseRequisition, $status);
        return $this->apiResponse(message: $message, status: 200);
    }

    public function listAllUndeliveredProductsById(PurchaseRequisition $purchaseRequisition)
    {
        /**  @var \App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionListUseCase::class);
        $result = $useCase->listAllUndeliveredProductsById($purchaseRequisition);
        return $this->apiResponse("showing undelivered product by requisition", $result);
    }

    public function pdf(PurchaseRequisition $purchaseRequisition)
    {
        /** @var PurchaseRequisitionDocumentPdfUseCase $useCase */
        $useCase = $this->container->get(PurchaseRequisitionDocumentPdfUseCase::class);
        return $useCase->execute($purchaseRequisition);
    }

}
