<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::prefix('auth')->name('auth.')->group(function(){
        Route::post('/login', 'login')->name('login');
    });
});

Route::get("product-categories", [ProductCategoryController::class, "index"]);