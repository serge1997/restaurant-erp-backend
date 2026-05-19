<?php

use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;

Route::controller(SupplierController::class)->group(function(){
    Route::prefix("suppliers")->name("suppliers.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{supplier}", "show")->name("show");
        Route::put("/", "update")->name("update");
    });
});