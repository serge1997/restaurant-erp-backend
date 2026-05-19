<?php
namespace App\Modules\Restaurant\Exceptions;

use Exception;
use Throwable;

class RestaurantNotFoundExecption extends Exception
{
    public function __construct(string $message = "Restaurante nao encontrado", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}