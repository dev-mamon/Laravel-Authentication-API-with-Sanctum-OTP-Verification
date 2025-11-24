<?php

use App\Http\Controllers\API\Auth\AuthApiController;
use App\Http\Controllers\API\CreativeDesign\CreativeDesignApiController;
use App\Http\Controllers\API\Fashion\FashionApiController;
use App\Http\Controllers\API\Finance\FinanceApiController;
use App\Http\Controllers\API\Journaling\JournalingApiController;
use App\Http\Controllers\API\Profile\ProfileApiController;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthApiController::class, 'loginApi']); // User login
    Route::post('register', [AuthApiController::class, 'registerApi']); // User registration
    Route::post('verify-email', [AuthApiController::class, 'verifyEmailApi']); // Verify email
    Route::post('forgot-password', [AuthApiController::class, 'forgotPasswordApi']); // Forgot password
    Route::post('reset-password', [AuthApiController::class, 'resetPasswordApi']); // Reset password
    Route::post('resend-otp', [AuthApiController::class, 'resendOtpApi']); // Resend OTP
    Route::post('verify-otp', [AuthApiController::class, 'verifyOtpApi']); // Verify OTP
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthApiController::class, 'logoutApi']);

    // journaling routes
    Route::get('journaling', [JournalingApiController::class, 'index']);
    Route::post('journal-submit', [JournalingApiController::class, 'submit']);
    Route::post('journal/share', [JournalingApiController::class, 'generate']);
    // finance routes
    Route::get('finances', [FinanceApiController::class, 'index']);
    Route::post('finances/submit', [FinanceApiController::class, 'submit']);
    Route::post('finances/share', [FinanceApiController::class, 'generate']);

    // Creative Design routes
    Route::get('creative-design', [CreativeDesignApiController::class, 'index']);
    Route::post('creative-design/submit', [CreativeDesignApiController::class, 'submit']);
    Route::post('creative-design/share', [CreativeDesignApiController::class, 'generate']);

    // update profile
    Route::post('update-profile', [ProfileApiController::class, 'updateProfile']);
    Route::post('update-password', [ProfileApiController::class, 'updatePassword']);
    Route::post('delete-account', [ProfileApiController::class, 'deleteAccount']);
    // get fashion
    Route::get('fashion', [FashionApiController::class, 'index']);
});
