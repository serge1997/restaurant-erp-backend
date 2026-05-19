<?php
namespace App\Modules\MenuCategory\UseCases;

use App\Http\Requests\MenuCategory\MenuCategoryCreateRequest;
use App\Modules\MenuCategory\Exceptions\MenuCategoryException;
use App\Modules\MenuCategory\Repository\MenuCategoryRepository;

final class MenuCategoryCreateUseCase
{
    public function __construct(
        private readonly MenuCategoryRepository $menuCategoryRepository
    ){}

    public function execute(MenuCategoryCreateRequest $request)
    {
        $name = strtolower($request->name);
        if ($this->menuCategoryRepository->existBy('name', ucfirst($name))){
            throw new MenuCategoryException('recurso já existe');
        }
        $this->menuCategoryRepository->save($request->validated());
    }
}