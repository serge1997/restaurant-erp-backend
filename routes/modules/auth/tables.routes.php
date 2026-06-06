<?php

use App\Http\Controllers\Api\TableController;
use Illuminate\Support\Facades\Route;

Route::controller(TableController::class)->group(function(){
    Route::prefix("tables")->name("tables.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/for-orders", "listForOrders")->name("listForOrders");
        Route::get("/availables", "listAvailables")->name("listAvailables");
        Route::get("/{table}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::delete("/{id}", "delete")->name("delete");
    });
});