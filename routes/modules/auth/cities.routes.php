<?php

use App\Http\Controllers\Api\CityController;
use Illuminate\Support\Facades\Route;

Route::controller(CityController::class)->group(function(){
    Route::prefix('cities')->name("cities.")->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/state/{uf}', 'indexByState')->name('indexByState');
    });
});