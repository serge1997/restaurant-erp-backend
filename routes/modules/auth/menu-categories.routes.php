<?php
use App\Http\Controllers\Api\MenuCategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(MenuCategoryController::class)->group(function(){
    Route::prefix("menuCategories")->name("menuCategories.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{menuCategory}", "show")->name("show");
        Route::put("/", "update")->name("update");
    });
});