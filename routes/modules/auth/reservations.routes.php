<?php

use App\Http\Api\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::controller(ReservationController::class)->group(function(){
    Route::prefix("reservations")->name("reservations.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{id}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::delete("/{id}", "delete")->name("delete");
    });
});
