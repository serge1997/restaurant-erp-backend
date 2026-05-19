<?php
namespace App\Modules\Table\UseCases;

use App\Http\Requests\Table\TableCreateRequest;
use App\Modules\Table\Exceptions\TableException;
use App\Modules\Table\Repository\TableRepository;

final class TableCreateUseCase
{
    public function __construct(
        private readonly TableRepository $tableRepository
    ){}

    public function execute(TableCreateRequest $request)
    {
        $payload = $request->validated();
        $existsByNumber = $this->tableRepository->findBy(["number"], $payload["number"]);
        if ($existsByNumber){
            throw new TableException("Uma mesa já existe com esse numero");
        }
        if ($payload["name"]) {
            $existsByname = $this->tableRepository->findBy(["name"], $payload["name"]);
            if ($existsByname){
                throw new TableException("Uma mesa já existe com esse nome");
            }
        }
        $this->tableRepository->save($payload);
    }
}