<?php

use App\Http\Controllers\Api\StockMovmentController;
use Illuminate\Support\Facades\Route;

Route::controller(StockMovmentController::class)->group(function(){
    Route::prefix("stockMovements")->name("stockMovements.")->group(function(){
        Route::post("/", "store")->name("store");
        Route::get("/", "index")->name("index");
        Route::get("/{stockMovment}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::get('/list-last-by-product/{product}', 'listLastProduct')->name('listLastProduct');
    });
});