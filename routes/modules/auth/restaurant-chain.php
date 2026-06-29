<?php
use App\Http\Controllers\Api\RestaurantChainController;
use Illuminate\Support\Facades\Route;

Route::controller(RestaurantChainController::class)->group(function(){
    Route::prefix("restaurantChains")->name("restaurantChains.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{restaurantChain}", "show")->name("show");
        Route::put("/", "update")->name("update");
    });
});