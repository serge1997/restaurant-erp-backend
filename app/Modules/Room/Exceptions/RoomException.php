<?php
namespace App\Modules\Room\Exceptions;

use Throwable;

class RoomException extends \Exception
{
    public function __construct(string $message, int $code = 400, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}