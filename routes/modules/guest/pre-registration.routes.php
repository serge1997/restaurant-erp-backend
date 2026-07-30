<?php
use App\Http\Controllers\Api\PreRegistrationController;
use Illuminate\Support\Facades\Route;


Route::controller(PreRegistrationController::class)->group(function(){
    Route::prefix('preRegistrations')->name('preRegistrations.')->group(function(){
        Route::post("/", "store")->name("store");
        Route::get("/listByToken/{token}", "listByToken")->name("listByToken");
        Route::put("/confirmation", "confirmation")->name("confirmation");
        Route::put("/regenerateConfirmationToken/{preRegistration}", "regenerateConfirmationToken")->name("regenerateConfirmationToken");
    });
});