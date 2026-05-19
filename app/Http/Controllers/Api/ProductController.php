<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;

class ProductController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\Product\UseCases\ProductListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Product\UseCases\ProductListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of products", $result);
    }

    public function show(Product $product)
    {
        /**  @var \App\Modules\Product\UseCases\ProductListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Product\UseCases\ProductListUseCase::class);
        $result = $useCase->listById($product);
        return $this->apiResponse("showing a product", $result);
    }

    public function store(ProductCreateRequest $request)
    {
        /**  @var \App\Modules\Product\UseCases\ProductCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Product\UseCases\ProductCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "produto criado com successo", status: 201);
    }

    public function update(ProductUpdateRequest $request)
    {
        /**  @var \App\Modules\Product\UseCases\ProductUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\Product\UseCases\ProductUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "produto alterado com successo", status: 200);
    }

}
