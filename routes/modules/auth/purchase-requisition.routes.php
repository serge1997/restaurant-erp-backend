<?php

use App\Http\Controllers\Api\PurchaseRequisitionController;
use Illuminate\Support\Facades\Route;

Route::controller(PurchaseRequisitionController::class)->group(function(){
    Route::prefix("purchaseRequisitions")->name("purchaseRequisitions.")->group(function(){
        Route::get("/",  "index")->name("index");
        Route::post("/", "store")->name("store");
        Route::get("/{purchaseRequisition}", "show")->name("show");
        Route::put("/", "update")->name("update");
        Route::put("/attache-status/{purchaseRequisition}/status/{status}", "attacheStatus")->name("attacheStatus");
        Route::get("/list-undelivered-products-by-id/{purchaseRequisition}", "listAllUndeliveredProductsById")->name("listAllUndeliveredProductsById");
        Route::get("/{purchaseRequisition}/pdf", "pdf")->name("pdf");
    });
});