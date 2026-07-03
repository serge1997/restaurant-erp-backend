<?php
use App\Http\Controllers\Api\RestaurantChainController;
use Illuminate\Support\Facades\Route;

Route::controller(RestaurantChainController::class)->group(function(){
    Route::prefix("restaurantChains")->name("restaurantChains.")->group(function(){
        Route::post("/", "store")->name("store");
        Route::get("/",  "index")->name("index");
        Route::get("/{restaurantChain}", "show")->name("show");
        Route::put("/", "update")->name("update");
    });
});