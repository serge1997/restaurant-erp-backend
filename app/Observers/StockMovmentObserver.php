<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockMovment;
use App\Modules\Alert\Enums\AlertSeverityEnum;
use App\Modules\Alert\Infra\Repository\AlertRepository;
use Illuminate\Support\Facades\Log;

class StockMovmentObserver
{

    public function __construct(
        private readonly AlertRepository $alertRepository
    ){}
    /**
     * Handle the StockMovment "created" event.
     */
    public function created(StockMovment $stockMovment): void
    {
        $payload = $this->alertPayloadProvider($stockMovment);
        $productUnresolvedAlert = $stockMovment->product->unresolvedAlert();
        if($productUnresolvedAlert->exists()){
            if(!$this->quantityIsAlertable($stockMovment)){
                if($stockMovment->reference_type->isIn()){
                    $this->alertRepository->update($stockMovment->product->unresolvedAlert, [
                        'is_resolved'   => true
                    ]);
                }
                return;
            }
            $this->alertRepository->update($stockMovment->product->unresolvedAlert, $payload);
            return;
        }
        if($this->quantityIsAlertable($stockMovment)){
            $this->alertRepository->save($payload);
        }
    }

    /**
     * Handle the StockMovment "updated" event.
     */
    public function updated(StockMovment $stockMovment): void
    {
        //
    }

    /**
     * Handle the StockMovment "deleted" event.
     */
    public function deleted(StockMovment $stockMovment): void
    {
        //
    }

    /**
     * Handle the StockMovment "restored" event.
     */
    public function restored(StockMovment $stockMovment): void
    {
        //
    }

    /**
     * Handle the StockMovment "force deleted" event.
     */
    public function forceDeleted(StockMovment $stockMovment): void
    {
        //
    }

    private function alertPayloadProvider(StockMovment $stockMovment): array
    {
        $product = $stockMovment->product;
        [$title, $description] = $this->alertTitleAndDescription($stockMovment, $product);
        $severity = $this->getAlertSeverity($stockMovment);
        return [
            "title"             =>  $title,
            "description"       => $description,
            "severity"          => $severity->value,
            "alertable_type"    => Product::class,
            "alertable_id"      => $product->id,
        ];
    }

    private function alertTitleAndDescription(StockMovment $stockMovment ,Product $product): ?array
    {
        $formattedQuantity = $stockMovment->formatQuantity($stockMovment->current_stock);
        if($stockMovment->stockIsEmpty()){
            return ['Estoque vazio', $product->name . " está com estoque zerado."];
        }
        if($stockMovment->stockIsCritical()){
            return  ["Estoque Crítico", $product->name . " - apenas {$formattedQuantity} restante(s)."];
        }
        if($stockMovment->quantityIsAlertable()){
            return  ["Estoque baixo", $product->name . " - {$formattedQuantity} restante(s)."];
        }
        return null;
    }

    public function getAlertSeverity(StockMovment $stockMovment): ?AlertSeverityEnum
    {
        if($stockMovment->stockIsEmpty() || $stockMovment->stockIsCritical()){
            return AlertSeverityEnum::URGENT;
        }
        if($stockMovment->quantityIsAlertable()){
            return  AlertSeverityEnum::WARNING;
        }
        return AlertSeverityEnum::INFO;
    }

    public function quantityIsAlertable(StockMovment $stockMovment): bool
    {
        if($stockMovment->stockIsEmpty() || $stockMovment->stockIsCritical() || $stockMovment->quantityIsAlertable()){
            return true;
        }
       return false;
    }
}
