<?php
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->group(function(){
    Route::prefix("orders")->name("orders.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{order}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::delete("/{id}", "delete")->name("delete");
        Route::put("/transfert", "transfert")->name("transfert");
        Route::put("/{order}/payment-method/{paymentMethod}", "paymentMethod")->name("paymentMethod");
        Route::put("/cancel-item", "cancelItem")->name("cancelItem");
        Route::put("/cancel", "cancel")->name("cancelItem");
    });
});