<?php

use App\Http\Controllers\Api\ModuleController;
use Illuminate\Support\Facades\Route;

Route::controller(ModuleController::class)->group(function(){
    Route::prefix('modules')->name("names.")->group(function(){
        Route::get('/', 'index')->name('index');
    });
});