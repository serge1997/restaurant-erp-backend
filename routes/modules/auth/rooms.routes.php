<?php

use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

Route::controller(RoomController::class)->group(function(){
    Route::prefix("rooms")->name("rooms.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{room}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::delete("/{id}", "delete")->name("delete");
    });
});