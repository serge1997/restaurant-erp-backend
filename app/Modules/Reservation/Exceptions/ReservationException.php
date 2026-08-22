<?php
namespace App\Modules\Reservation\Exceptions;

use Exception;

class ReservationException extends \Exception
{
    public function __construct(string $message, int $code = 501)
    {
        parent::__construct($message, $code);
    }

    public function notFound(): self
    {
        return new self("reserva nao encontrada", 404);
    }
}
