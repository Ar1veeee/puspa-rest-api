<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/registration', [RegistrationController::class, 'store']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [PasswordResetController::class, 'forgotPassword'])
    ->name('password.email');
Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.reset');

Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resendNotification'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('verified')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/protected', [AuthController::class, 'protected']);
    });
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins/{admin_id}', [AdminController::class, 'show']);
    Route::put('/admins/{admin_id}', [AdminController::class, 'update']);
    Route::delete('/admins/{admin_id}', [AdminController::class, 'destroy']);

    Route::get('/therapists', [TherapistController::class, 'index']);
    Route::post('/therapists', [TherapistController::class, 'store']);
    Route::get('/therapists/{therapist_id}', [TherapistController::class, 'show']);
    Route::put('/therapists/{therapist_id}', [TherapistController::class, 'update']);
    Route::delete('/therapists/{therapist_id}', [TherapistController::class, 'destroy']);
});
