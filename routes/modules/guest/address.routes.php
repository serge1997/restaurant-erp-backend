<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Support\Facades\Route;

//set middleware to not allow request
Route::get('/states', [\App\Http\Controllers\Api\StateController::class, 'index']);
Route::controller(AddressController::class)->group(function(){
    Route::prefix("addresses")->name("address")->group(function(){
        Route::get("cep/{cep}", "cep")->name("cep");
    });
});