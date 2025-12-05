<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/sanctum/csrf-cookie', \Laravel\Sanctum\Http\Controllers\CsrfCookieController::class . '@show');

Route::controller(AuthController::class)
    ->group(function() {
        Route::post('/register', 'register');
        Route::post('login', 'login');
        Route::post('/verify-otp', 'verifyOTP');
        Route::post('/resend-otp', 'resendOTP');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/reset-password', 'resetPassword');
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});