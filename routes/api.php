<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\langController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




Route::post("/local/{lang}", [langController::class,"setlocale"]);


Route::prefix("v1")->group(function () {

Route::post("/register",[AuthController::class,"register"]);

Route::middleware(['verified'])->group(function()
{

    Route::get("/show",[AuthController::class,"show"]);
});

});






/*
Route::get('/email/verify', function () {
    return view("verification.failed") ;

})->middleware('auth')->name('verification.notice'); */





Route::get('/email/verify/{id}/{hash}', [VerificationController::class,"verify"])
->middleware(['signed'])->name('verification.verify');


Route::post('/email/resendExpired', [VerificationController::class, 'resendExpired'])
    ->middleware([ 'throttle:6,1']) // limit to 6 attempts per minute
    ->name('verification.send');
