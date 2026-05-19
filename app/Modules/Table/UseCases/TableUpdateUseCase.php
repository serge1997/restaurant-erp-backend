<?php
namespace App\Modules\Table\UseCases;

use App\Http\Requests\Table\TableUpdateRequest;
use App\Modules\Table\Exceptions\TableException;
use App\Modules\Table\Repository\TableRepository;

final class TableUpdateUseCase
{
    public function __construct(
        private readonly TableRepository $tableRepository
    ){}

    public function execute(TableUpdateRequest $request)
    {
        $payload = $request->validated();
        $table = $this->tableRepository->find($payload["id"]);
        if (!$table){
            throw new TableException("Mesa nao encontrada", 404);
        }
        if ($payload["name"]){
            $existsByname = $this->tableRepository->findBy(["name", "id:not"], $payload["name"], $table->id);
            if ($existsByname){
                throw new TableException("Uma mesa já existe com esse nome");
            }
        }
        $this->tableRepository->update($table, $payload);
    }
}