<?php
namespace App\Modules\MenuItem\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\MenuItem\MenuItemFormResource;
use App\Http\Resources\MenuItem\MenuItemResource;
use App\Models\MenuItem;
use App\Modules\MenuItem\Repository\MenuItemRepository;

final class MenuItemListUseCase
{
    public function __construct(
        private readonly MenuItemRepository $menuItemRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        return MenuItemResource::collection(
            $this->menuItemRepository->findAll($paginate)
        );
    }

    public function listById(MenuItem $menuItem)
    {
        return new MenuItemFormResource($menuItem);
    }
}