<?php
namespace App\Modules\StockMovment\Enums;

enum StockMovmentDirectionEnum: int
{
    case IN = 1;
    case OUT = 2;

    public function getLabel(): string
    {
        return match($this) {
            self::IN => "Entrada",
            self::OUT => "Saída"
        };
    }

    public function getSeverity(): string
    {
        return match($this) {
            self::IN => "tag-green-dark",
            self::OUT => "tag-danger"
        };
    }

    public function getFontColor(): string
    {
        return match($this) {
            self::IN => "c-green-primary",
            self::OUT => "c-danger-primary"
        };
    }

    public function isIn(): bool
    {
        return $this->value === self::IN;
    }

    public function isOut(): bool
    {
        return $this->value === self::OUT;
    }
}