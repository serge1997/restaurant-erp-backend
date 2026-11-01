<?php
namespace App\Modules\Product\Enums;


enum ProductInStockLabelEnum: int
{
    case AVAILABLE = 1;
    case UNVAILABLE = 2;
    case LOW = 3;

    public function getLabel(): ?string 
    {
        return match($this) {
            self::AVAILABLE     => "Disponivél",
            self::UNVAILABLE    => "Indisponivél",
            self::LOW           => "Baixo",
            default => null
        };
    }

    public function getSeverity(): ?string
    {
        return match($this){
            self::AVAILABLE     => "tag-green-dark",
            self::UNVAILABLE    => "tag-purple",
            self::LOW           => "tag-amber",
            default => null
        };
    }

    public function isLow(): bool
    {
        return $this === self::LOW;
    }

    public function isUnvailable(): bool
    {
        return $this === self::UNVAILABLE;
    }

}