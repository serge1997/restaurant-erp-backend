<?php

use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::controller(RestaurantController::class)->group(function(){
    Route::prefix("restaurants")->name("restaurants.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{restaurant}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::post("/files", "updateFiles")->name("update");
    });
});