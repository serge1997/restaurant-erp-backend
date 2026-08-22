<?php
namespace App\Modules\Reservation\Enums;

enum ReservationStatusEnum: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case CANCELLED = 3;
    case SEATED = 4;

    public function getLabel(): string
    {
        return match(self){
            self::PENDING   => "Pendente",
            self::CONFIRMED => "Confirmada",
            self::CANCELLED => "Cancelada",
            self::SEATED    => "Sentado"
        };
    }

    public function isPending(): bool
    {
        return $this == self::PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this == self::CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this == self::CANCELLED;
    }

    public function isSeated(): bool
    {
        return $this == self::SEATED;
    }
}
