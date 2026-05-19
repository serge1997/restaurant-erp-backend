<?php
namespace App\Modules\StockMovment\Handlers;

use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
use App\Modules\StockMovment\Exceptions\StockMovementException;
use App\Modules\StockMovment\Handlers\PurchaseHandler;
use App\Modules\StockMovment\Handlers\Contracts\StockMovmentHandlerInterface;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

class StockMovmentHandler
{
    public function __construct(
        private readonly StockMovmentRepository $stockMovmentRepository
    )
    {}
    public function handler(StockMovmentReferenceTypeEnum $stockMovmentReferenceTypeEnum): StockMovmentHandlerInterface
    {
        return match($stockMovmentReferenceTypeEnum) {
            StockMovmentReferenceTypeEnum::PURCHASE => new PurchaseHandler($this->stockMovmentRepository),
            StockMovmentReferenceTypeEnum::SALE => new SaleHandler($this->stockMovmentRepository),
            StockMovmentReferenceTypeEnum::DEVOLUTION_SALE => new SaleDevolutionHandler($this->stockMovmentRepository),
            StockMovmentReferenceTypeEnum::MANUAL_IN => new ManualInHandler($this->stockMovmentRepository),
            StockMovmentReferenceTypeEnum::MANUAL_OUT, StockMovmentReferenceTypeEnum::DEVOLUTION_SUPPLIER, StockMovmentReferenceTypeEnum::WASTE => new ManualOutHandler($this->stockMovmentRepository),
            default => throw new StockMovementException("Tipo da movimentaçao nao existe", 400)
        };
    }
}