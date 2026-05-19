<?php
namespace App\Modules\Payment\Enums;

enum PaymentStatusEnum: int 
{
    case PENDING = 1;
    case PAID = 2;
    case OFFER = 3;

    public function getLabel(): string
    {
        return match($this){
            self::PENDING   => "pendente",
            self::PAID      => "pago",
            self::OFFER     => "oferta"
        };
    }

    public function isPaid(): bool
    {
        return $this == self::PAID;
    }
}