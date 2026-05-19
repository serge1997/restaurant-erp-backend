<?php

use App\Http\Controllers\Api\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::controller(MenuItemController::class)->group(function(){
    Route::prefix("menuItems")->name("menuItems.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{menuItem}", "show")->name("show");
        Route::post("/{menuItem}", "update")->name("update");
    });
});