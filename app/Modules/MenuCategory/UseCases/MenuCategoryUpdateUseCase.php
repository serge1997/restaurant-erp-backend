<?php
namespace App\Modules\MenuCategory\UseCases;

use App\Http\Requests\MenuCategory\MenuCategoryUpdateRequest;
use App\Modules\MenuCategory\Exceptions\MenuCategoryNotFoundException;
use App\Modules\MenuCategory\Repository\MenuCategoryRepository;

final class MenuCategoryUpdateUseCase
{
    public function __construct(
        private readonly MenuCategoryRepository $menuCategoryRepository
    ){}

    public function execute(MenuCategoryUpdateRequest $request)
    {
        $menuCategory = $this->menuCategoryRepository->find($request->id);
        if (!$menuCategory){
            throw new MenuCategoryNotFoundException;
        }
        $this->menuCategoryRepository->update($menuCategory, $request->validated());
    }
}