<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RoutePermissionMiddleware
{
    private $allowedRoutes = [
        'api.tables.listAllWithOrderStatus',
        'api.orders.homeKpis',
        'api.tables.listAllWithOrderStatus',
        'api.alerts.index',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $auth */
        $auth = request()->user();
        $routeName = sprintf("api.%s",$request->route()->getName());
        if(!in_array($routeName, $this->allowedRoutes)){
            $permissions = Cache::get(sprintf("%s_%d_%s", "user", $auth->id, "permissions"), []);
            $permissions = json_decode($permissions, true);
            $hasPermission = collect($permissions)->contains(function ($permission) use ($routeName) {
                return $permission['name'] === $routeName;
            });
            if (!$hasPermission) {
                return response()->json([
                    'message' => 'Permission denied for this route',
                ], 403);
            }
        }
        return $next($request);
    }
}
