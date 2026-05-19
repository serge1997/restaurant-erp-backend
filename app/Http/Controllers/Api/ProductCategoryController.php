<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends BaseApiController
{

    public function index(PaginateRequest $paginate): JsonResponse
    {
        /** @var \App\Modules\ProductCategory\UseCases\ProductCategoryListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\ProductCategory\UseCases\ProductCategoryListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse('list of products categories', $result);
    }

    public function show(ProductCategory $productCategory): JsonResponse
    {
        /* @var \App\Modules\ProductCategory\UseCases\ProductCategoryShowUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\ProductCategory\UseCases\ProductCategoryListUseCase::class);
        $result = $useCase->listById($productCategory);
        return $this->apiResponse('showing product category details', $result);
     }
}
