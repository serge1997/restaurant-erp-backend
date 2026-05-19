<?php

use App\Http\Controllers\Api\PurchaseRequisitionItemController;
use Illuminate\Support\Facades\Route;

Route::controller(PurchaseRequisitionItemController::class)->group(function(){
    Route::prefix("purchaseRequisitionItems")->name("purchaseRequisitionItems.")->group(function(){
        Route::get("/list-last-delivery-of-product/{product_id}",  "listLastDeliveryOfProduct")->name("listLastDeliveryOfProduct");
    });
});