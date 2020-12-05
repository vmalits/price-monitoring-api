<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::middleware('auth:api')->group(function () {
        Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('roles', RoleController::class);
});
