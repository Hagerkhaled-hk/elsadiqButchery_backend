<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\langController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




Route::post("/local/{lang}", [langController::class,"setlocale"]);


Route::prefix("v1")->group(function () {

Route::get("/register",[AuthController::class,"register"]);

Route::middleware(['auth', 'verified'])->group(function()
{

    Route::get("/show",[AuthController::class,"show"]);
});
});




Route::get('/email/verify', function () {
    return view("verification.failed") ;

})->middleware('auth')->name('verification.notice');





Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return view("verification.success") ;
})->middleware(['auth', 'signed'])->name('verification.verify');




Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return view("verification.success") ;
})->middleware(['auth', 'signed'])->name('verification.verify');