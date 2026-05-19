<?php
namespace App\Modules\Table\UseCases;

use App\Modules\Table\Exceptions\TableException;
use App\Modules\Table\Repository\TableRepository;

final class TableDeleteUseCase
{
    public function __construct(
        private readonly TableRepository $tableRepository
    ){}

    public function execute(int $id)
    {
        $table = $this->tableRepository->find($id);
        if (!$table){
            throw new TableException("Mesa nao encontrada", 404);
        }
        $this->tableRepository->delete($table);
    }
}