<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    $authRoutes = glob(base_path("routes/modules/auth/*.routes.php"));
    if ($authRoutes) {
        foreach($authRoutes as $authRoute) {
            require $authRoute;
        }
    }
});

$guestRoutes = glob(base_path("routes/modules/guest/*.routes.php"));
if ($guestRoutes) {
    foreach($guestRoutes as $guestRoute) {
        require $guestRoute;
    }
}
