<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::prefix('auth')->name('auth.')->group(function(){
        Route::post('/logout', 'logout')->name('logout');
    });
});