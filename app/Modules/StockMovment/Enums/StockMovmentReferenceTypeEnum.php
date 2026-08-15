<?php
namespace App\Modules\StockMovment\Enums;

enum StockMovmentReferenceTypeEnum: int
{
    case PURCHASE = 1;
    case SALE = 2;
    case DEVOLUTION_SUPPLIER = 3;
    case DEVOLUTION_SALE = 4;
    case WASTE = 5;
    case MANUAL_IN = 6;
    case MANUAL_OUT = 7;

    public function getLabel(): string
    {
        return match($this){
            self::PURCHASE => "Compra",
            self::SALE => "Venda",
            self::DEVOLUTION_SUPPLIER => "Devoluçao para fornecedor",
            self::DEVOLUTION_SALE => "Devoluçao de venda",
            self::WASTE => "Gastos",
            self::MANUAL_IN => "Entrada manual",
            self::MANUAL_OUT => "Saida Manual"
        };
    }
    public function isPurchase(): bool
    {
        return $this->value === self::PURCHASE->value;
    }

    public function isSale(): bool
    {
        return $this->value === self::SALE->value;
    }

    public function isDevolutionSupplier(): bool
    {
        return $this->value === self::DEVOLUTION_SUPPLIER->value;
    }

    public function isDevolutionSale(): bool
    {
        return $this->value === self::DEVOLUTION_SALE->value;
    }

    public function isWaste(): bool
    {
        return $this->value === self::WASTE->value;
    }

    public function isManualIn(): bool
    {
        return $this->value === self::MANUAL_IN->value;
    }

    public function isManualOut(): bool
    {
        return $this->value === self::MANUAL_OUT->value;
    }

    public function getDirection(): StockMovmentDirectionEnum
    {
        return match($this){
            self::PURCHASE, self::DEVOLUTION_SALE, self::MANUAL_IN => StockMovmentDirectionEnum::IN,
            self::DEVOLUTION_SUPPLIER, self::SALE, self::WASTE, self::MANUAL_OUT => StockMovmentDirectionEnum::OUT
        };
    }

    public static function in(): array
    {
        return [
            self::PURCHASE->value, self::DEVOLUTION_SALE->value, self::MANUAL_IN->value
        ];
    }

    public static function out(): array
    {
        return [
            self::DEVOLUTION_SUPPLIER->value, self::SALE->value, self::WASTE->value, self::MANUAL_OUT->value
        ];
    }

    public function isIn(): bool
    {
        return in_array($this->value, $this->in());
    }
}