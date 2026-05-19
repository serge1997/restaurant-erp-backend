<?php

use App\Http\Controllers\Api\TechnicalSheetController;
use Illuminate\Support\Facades\Route;

Route::controller(TechnicalSheetController::class)->group(function(){
    Route::prefix("technicalSheets")->name("technicalSheets.")->group(function(){
        Route::post("/", "store")->name("store");
        Route::get("/list-by-menu-item/{menuItem}", "listByMenuItem")->name("listByMenuItem");
        Route::put("/", "update")->name("update");
    });
});