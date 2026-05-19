<?php
namespace App\Modules\Table\UseCases;

use App\Foundation\Base\BaseUseCase;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Table\TableResource;
use App\Models\Table;
use App\Modules\Table\Repository\TableRepository;

final class TableListUseCase extends BaseUseCase
{
    public function __construct(
        private readonly TableRepository $tableRepository
    )
    {
        parent::__construct($tableRepository);
    }

    public function execute(PaginateRequest $paginate)
    {
        return TableResource::collection(
            $this->tableRepository->findAll($paginate)
        )->additional(array_merge(
            $this->getActivesMetada(),
            $this->totalMetadata(),
            [
                "capacity"  => $this->tableRepository->queryTotalCapacity()
            ]
        ));
    }

    public function listById(Table $table)
    {
        return new TableResource($table);
    }

    public function listForOrders(): array
    {
        return [
            "available_tables" => TableResource::collection($this->tableRepository->findAllAvailable()),
            "tables_with_orders" => $this->tableRepository->findAllWithOrders()
        ];
    }
}