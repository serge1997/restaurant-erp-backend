<?php
use App\Http\Controllers\Api\AlertController;
use Illuminate\Support\Facades\Route;

Route::controller(AlertController::class)->group(function(){
    Route::prefix("alerts")->name("alerts.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{alert}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::delete("/{id}", "delete")->name("delete");
    });
});