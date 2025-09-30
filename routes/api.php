<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [RegistrationController::class, 'store'])
    ->middleware('throttle:api');

Route::post('/auth/register', [AuthController::class, 'register'])
    ->middleware('throttle:register');

Route::post('/auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');

Route::post('/auth/forgot-password', [PasswordResetController::class, 'forgotPassword'])
    ->name('password.email')
    ->middleware('throttle:forgot-password');

Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.reset')
    ->middleware('throttle:reset-password');

Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:verification'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resendNotification'])
    ->middleware('throttle:verification-resend')
    ->name('verification.send');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('verified')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout'])
            ->middleware('throttle:logout');

        Route::get('/observations/scheduled', [ObservationController::class, 'indexScheduled'])
            ->middleware('throttle:authenticated');

        Route::get('/auth/protected', [AuthController::class, 'protected'])
            ->middleware('throttle:authenticated');
    });
});

Route::middleware(['auth:sanctum', 'role:admin', 'throttle:admin'])->group(
    function () {
        Route::get('/admins', [AdminController::class, 'index']);
        Route::post('/admins', [AdminController::class, 'store']);
        Route::get('/admins/{admin_id}', [AdminController::class, 'show']);
        Route::put('/admins/{admin_id}', [AdminController::class, 'update']);
        Route::delete('/admins/{admin_id}', [AdminController::class, 'destroy']);

        Route::get('/children', [ChildController::class, 'index']);
        Route::get('/children/{child_id}', [ChildController::class, 'show']);

        Route::get('/therapists', [TherapistController::class, 'index']);
        Route::post('/therapists', [TherapistController::class, 'store']);
        Route::get('/therapists/{therapist_id}', [TherapistController::class, 'show']);
        Route::put('/therapists/{therapist_id}', [TherapistController::class, 'update']);
        Route::delete('/therapists/{therapist_id}', [TherapistController::class, 'destroy']);

        Route::get('/observations/pending', [ObservationController::class, 'indexPending']);
        Route::put('/observations/{observation_id}', [ObservationController::class, 'update']);
    }
);

Route::middleware(['auth:sanctum', 'role:terapis', 'throttle:therapist'])->group(
    function () {
        Route::get('/observations/scheduled/{observation_id}', [ObservationController::class, 'showScheduled']);
        Route::get('/observations/question/{observation_id}', [ObservationController::class, 'showQuestion']);
        Route::post('/observations/submit/{observation_id}', [ObservationController::class, 'submit']);
        Route::get('/observations/completed', [ObservationController::class, 'indexCompleted']);
        Route::get('/observations/completed/{observation_id}', [ObservationController::class, 'showCompleted']);
    }
);
