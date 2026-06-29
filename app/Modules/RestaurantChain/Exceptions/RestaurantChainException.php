<?php
namespace App\Modules\RestaurantChain\Exceptions;

use Throwable;

class RestaurantChainException extends \Exception
{
    public function __construct(string $message = "", int $code = 501, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }

    public static function notFound(): RestaurantChainException
    {
        return new self("registro nao encontrado", 404);
    }
}