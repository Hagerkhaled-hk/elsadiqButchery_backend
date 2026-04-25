<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\langController;

use Illuminate\Support\Facades\Route;


Route::prefix("v1")->group(function () {

    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);

    Route::middleware(['verified'])->group(function () {
        // Use 'auth' or 'auth:web' for stateful session-based auth
        Route::middleware("auth:web")->group(function () {
            Route::post("/logout", [AuthController::class, "logout"]);
            Route::get("/show", [AuthController::class, "show"]);
        });
    });
});

Route::post("/local/{lang}", [langController::class, "setlocale"]);


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, "verify"])
    ->middleware(['signed'])->name('verification.verify');


Route::post('/email/resendExpired', [VerificationController::class, 'resendExpired'])
    ->middleware(['throttle:6,1']) // limit to 6 attempts per minute
    ->name('verification.send');
