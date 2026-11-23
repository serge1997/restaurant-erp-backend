<?php
namespace App\Modules\MenuItem\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\MenuItem\MenuItemFormResource;
use App\Http\Resources\MenuItem\MenuItemResource;
use App\Models\MenuItem;
use App\Modules\MenuCategory\Repository\MenuCategoryRepository;
use App\Modules\MenuItem\Repository\MenuItemRepository;

final class MenuItemListUseCase
{
    public function __construct(
        private readonly MenuItemRepository $menuItemRepository,
        private readonly MenuCategoryRepository $menuCategoryRepository
    ){}

    public function execute(PaginateRequest $paginate)
    {
        if($paginate->most_ordered){
            $toOrderedIds = $this->menuItemRepository->findtopOrdered()
                ->limit(50)->pluck("id")->toArray();
            $paginate->merge(["ids" => $toOrderedIds]);
        }
        return MenuItemResource::collection(
            $this->menuItemRepository->findAll($paginate)
        );
    }

    public function listById(MenuItem $menuItem)
    {
        return new MenuItemFormResource($menuItem);
    }
}