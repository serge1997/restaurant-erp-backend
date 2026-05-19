<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseMetaDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);
        if ($response instanceof JsonResponse) {
            $responseContent = json_decode($response->getContent(), true);
            $responseWithMetada = array_merge(
                $responseContent,
                ['timestamps' => $response->getDate()]
            );
            $response->setData($responseWithMetada);
        }
        return $response;
    }

    private function getMetada(array $response): array
    {
        $meta = [];
        $data = isset($response['data']) ? $response['data'] : [];
        $meta['total'] = count($data);
        return $meta;
    }
}
