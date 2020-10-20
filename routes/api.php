<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', RegisterController::class);
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
});

