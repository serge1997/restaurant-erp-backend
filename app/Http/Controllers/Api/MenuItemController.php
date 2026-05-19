<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Base\BaseApiController;
use App\Http\Requests\MenuItem\MenuItemCreateRequest;
use App\Http\Requests\MenuItem\MenuItemUpdateRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\MenuItem;

class MenuItemController extends BaseApiController
{
    

    public function index(PaginateRequest $paginate)
    {
        /**  @var \App\Modules\MenuItem\UseCases\MenuItemListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuItem\UseCases\MenuItemListUseCase::class);
        $result = $useCase->execute($paginate);
        return $this->apiResponse("list of MenuItems", $result);
    }

    public function show(MenuItem $menuItem)
    {
        /**  @var \App\Modules\MenuItem\UseCases\MenuItemListUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuItem\UseCases\MenuItemListUseCase::class);
        $result = $useCase->listById($menuItem);
        return $this->apiResponse("showing a MenuItem", $result);
    }

    public function store(MenuItemCreateRequest $request)
    {
        /**  @var \App\Modules\MenuItem\UseCases\MenuItemCreateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuItem\UseCases\MenuItemCreateUseCase::class);
        $useCase->execute($request);
        return $this->apiResponse(message: "menu item criado com successo", status: 201);
    }

    public function update(MenuItem $menuItem, MenuItemUpdateRequest $request)
    {
        /**  @var \App\Modules\MenuItem\UseCases\MenuItemUpdateUseCase $useCse  */
        $useCase = $this->container->get(\App\Modules\MenuItem\UseCases\MenuItemUpdateUseCase::class);
        $useCase->execute($menuItem, $request);
        return $this->apiResponse(message: "menu item alterado com successo", status: 200);
    }
}
