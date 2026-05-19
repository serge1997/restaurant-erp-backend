<?php

use App\Http\Middleware\JsonResponseMetaDataMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(JsonResponseMetaDataMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

       $exceptions->render(function(\Throwable $e, $request) {
            $code = $e->getCode();
            $status = is_int($code) && $code ? $code : 501; 
            $message = null;
            $data = [];
            if ($e instanceof ValidationException) {
                $status = 422;
                $data = $e->errors();
            }
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                $status = 404;
                $message = 'Recurso não encontrado ' . $e->getMessage();
            }

            return response()->json([
                'message' => $message ?? $e->getMessage(),
                'data' => $data,
                'success' => false,
                "code" => $status
            ], $status);
        });
    })->create();
