<?php
namespace App\Modules\Order\Exceptions;

class OrderException extends \Exception
{
    public function __construct(string $message, int $code = 501, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    public static function notFound(): self
    {
        return new self('Pedido nao encontrado.', 404);
    }
}