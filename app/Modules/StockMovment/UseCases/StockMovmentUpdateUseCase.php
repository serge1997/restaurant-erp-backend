<?php
namespace App\Modules\StockMovment\UseCases;

use App\Http\Requests\StockMovment\StockMovmentUpdateRequest;
use App\Modules\StockMovment\Repository\StockMovmentRepository;

final class StockMovmentUpdateUseCase
{

    public function __construct(
        private StockMovmentRepository $stockMovmentRepository
    ){}

    public function execute(StockMovmentUpdateRequest $request)
    {
        
    }
}