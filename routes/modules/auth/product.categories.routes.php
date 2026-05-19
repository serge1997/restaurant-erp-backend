<?php

use App\Http\Controllers\Api\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductCategoryController::class)->group(function () {
    Route::prefix('productCategories')->name("productCategories.")->group(function () {
        Route::get('/', 'index');
        Route::get('/{productCategory}', 'show');
    });
});