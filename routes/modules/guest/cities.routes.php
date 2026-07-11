<?php

use App\Http\Controllers\Api\CityController;
use Illuminate\Support\Facades\Route;

//set middleware to not allow request
Route::controller(CityController::class)->group(function(){
    Route::prefix('cities')->name("cities.")->group(function(){
        Route::get('/state/{uf}', 'indexByState')->name('indexByState');
    });
});