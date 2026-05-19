<?php
namespace App\Modules\MenuCategory\UseCases;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\MenuCategory\MenuCategoryResource;
use App\Models\MenuCategory;
use App\Modules\MenuCategory\Repository\MenuCategoryRepository;

final class MenuCategoryListUseCase
{
    public function __construct(
        private readonly MenuCategoryRepository $menuCategoryRepository
    ){}

    public function execute(PaginateRequest $paginateRequest)
    {
        return MenuCategoryResource::collection(
            $this->menuCategoryRepository->findAll($paginateRequest)
        );
    }

    public function listById(MenuCategory $menuCategory)
    {
        return new MenuCategoryResource($menuCategory);
    }
}