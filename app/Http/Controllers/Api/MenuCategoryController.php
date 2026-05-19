<?php
namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\MenuCategory\MenuCategoryCreateRequest;
use App\Http\Requests\MenuCategory\MenuCategoryUpdateRequest;
use App\Models\MenuCategory;

class MenuCategoryController extends BaseApiController
{

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\MenuCategory\UseCases\MenuCategoryListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuCategory\UseCases\MenuCategoryListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of menu categorys", $result);
    }

    public function show(MenuCategory $menuCategory)
    {
        /**  @var \App\Modules\MenuCategory\UseCases\MenuCategoryListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuCategory\UseCases\MenuCategoryListUseCase::class);
        $result = $useCase->listById($menuCategory);
        return $this->apiResponse("showing a menu category", $result);
    }

    public function store(MenuCategoryCreateRequest $request)
    {
        /**  @var \App\Modules\MenuCategory\UseCases\MenuCategoryCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuCategory\UseCases\MenuCategoryCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "Categoria do menu criada com successo", status: 201);
    }

    public function update(MenuCategoryUpdateRequest $request)
    {
        /**  @var \App\Modules\MenuCategory\UseCases\MenuCategoryUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuCategory\UseCases\MenuCategoryUpdateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "Categoria do menu alterada com successo", status: 200);
    }

}
