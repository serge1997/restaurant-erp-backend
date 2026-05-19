<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Modules\PurchaseRequisition\UseCases\PurchaseRequisitionItemListUseCase;

class PurchaseRequisitionItemController extends BaseApiController
{

   public function listLastDeliveryOfProduct(int $product_id)
   {
        /** @var PurchaseRequisitionItemListUseCase $useCase */
        $useCase = $this->container->get(PurchaseRequisitionItemListUseCase::class);
        $response = $useCase->listLastDeliveryOfProduct($product_id);
        return $this->apiResponse("last product request detail", $response);
   }

}
