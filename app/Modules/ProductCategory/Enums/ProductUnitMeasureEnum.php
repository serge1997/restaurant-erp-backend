<?php
namespace App\Modules\ProductCategory\Enums;

enum ProductUnitMeasureEnum: string
{
    case ML = 'ML';
    case GRAM = 'G';
    case UNIT = 'UNIT';
    case KG = "KG";
    case CL = "CL";

    public function getLabel(): string
    {
        return match($this) {
            self::ML => "Ml",
            self::GRAM => "G",
            self::UNIT => "Un",
            default => throw new \Exception("Unidade de medida nao existe", 400)
        };
    }

    public function purchaseRequestLabel(): string
    {
        return match($this) {
            self::GRAM => "Kg",
            self::UNIT, self::ML => "Unidade(s)",
            default => throw new \Exception("Unidade de medida nao existe", 400)
        };
    }

    public function technicalSheetLabel(): string
    {
        return match($this) {
            self::GRAM, self::KG => "g",
            self::UNIT => "unidade",
            self::CL, self::ML => "ml",
            default => throw new \Exception("Unidade de medida nao existe", 400)
        };
    }

    public function isMl(): bool
    {
        return $this->value === self::ML->value;
    }

    public function isGramm(): bool
    {
        return $this->value === self::GRAM->value;
    }

    public function isUnit(): bool
    {
        return $this->value === self::UNIT->value;
    }

    public function isKg(): bool
    {
        return $this->value === self::KG;
    }
}