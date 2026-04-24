<?php
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {

    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);

    Route::middleware(['verified'])->group(function () {
        // Use 'auth' or 'auth:web' for stateful session-based auth
        Route::middleware("auth")->group(function () {
            Route::post("/logout", [AuthController::class, "logout"]);
            Route::get("/show", [AuthController::class, "show"]);
        });
    });
});
