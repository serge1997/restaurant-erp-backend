<?php

use App\Http\Controllers\Api\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::controller(RoomTypeController::class)->group(function(){
    Route::prefix("roomTypes")->name("roomTypes.")->group(function(){
        Route::get("/", "index")->name("index");
    });
});