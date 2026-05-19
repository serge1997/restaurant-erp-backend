<?php
namespace App\Foundation\Base;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Psr\Container\ContainerInterface;

abstract class BaseApiController
{
    public function __construct(
        protected readonly ContainerInterface $container
    ){}

    public function apiResponse(string $message, mixed $data = [], bool $success = true, int $status = 200): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "success" => $success,
            "code" => $status,
            "meta" => $data instanceof JsonResource ? $data->additional : []
        ], $status);
    }

    public function apiErrorResponse(string $message,int $status = 400,  mixed $data = []): JsonResponse
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "success" => false,
            "code" => $status
        ], $status);
    }
}