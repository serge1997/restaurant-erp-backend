<?php
namespace App\Modules\Order\Enums;

enum OrderStatusEnum: int
{
    case OPEN = 1; 
    case SENT = 2;
    case DELIVERED = 3;
    case CLOSED = 4;
    case CANCELLED = 5;

    public function getLabel(): string
    {
        return match($this) {
            self::OPEN => 'aberto',
            self::SENT  => 'Enviado',
            self::DELIVERED => 'Entregado',
            self::CLOSED    => 'fechado',
            self::CANCELLED => 'cancelado'
        };
    }

    public function getSeverity(): string {
        return match($this) {
            self::OPEN => 'severity-amber',
            self::SENT  => 'severity-purple',
            self::DELIVERED => 'severity-blue',
            self::CLOSED    => 'severity-success',
            self::CANCELLED => 'severity-danger'
        };
    }
}