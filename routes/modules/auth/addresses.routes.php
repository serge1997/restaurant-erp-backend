<?php
use Illuminate\Support\Facades\Route;

Route::get('/states', [\App\Http\Controllers\Api\StateController::class, 'index']);