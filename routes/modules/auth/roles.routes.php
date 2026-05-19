<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleController::class)->group(function(){
    Route::prefix('roles')->name('roles.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('list-by-user/{user}', 'listByUser')->name('listByUser');
    });
});