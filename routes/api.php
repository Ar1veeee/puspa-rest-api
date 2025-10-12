<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PhysioAssessmentController;
use App\Http\Controllers\SpeechAssessmentController;
use App\Http\Controllers\OccupationalAssessmentController;
use App\Http\Controllers\PedagogicalAssessmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/cors-test', function () {
        return response()->json(['message' => 'CORS test successful!']);
    });

    Route::post('/registration', [RegistrationController::class, 'store'])
        ->middleware('throttle:api');

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->middleware('throttle:register');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:login');

        Route::get('/email-verify/{id}/{hash}', [VerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:verification'])
            ->name('verification.verify');
        Route::post('/resend-verification/{user}', [VerificationController::class, 'resendNotification'])
            ->name('verification.resend');
        Route::get('/resend-status/{user}', [VerificationController::class, 'checkResendStatus'])
            ->name('verification.status');

        Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
            ->middleware('throttle:forgot-password')
            ->name('password.email');
        Route::post('/resend-reset/{email}', [PasswordResetController::class, 'resendResetLink'])
            ->middleware('throttle:forgot-password')
            ->name('password.resend');
        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
            ->name('password.reset')
            ->middleware('throttle:reset-password');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])
            ->middleware('throttle:logout');
        Route::get('/auth/protected', [AuthController::class, 'protected']);

        Route::middleware(['verified', 'role:user'])->group(function () {
            Route::get('/my/children', [GuardianController::class, 'indexChildren']);
            Route::post('/my/children', [GuardianController::class, 'storeChild']);
            Route::put('/my/identity', [GuardianController::class, 'update']);
            Route::get('/my/assessments', [AssessmentController::class, 'indexChildren']);

            Route::prefix('assessments/{assessment}')->group(function () {
                Route::get('/', [AssessmentController::class, 'show']);
                Route::get('/general-data', [AssessmentController::class, 'showGeneralData']);
                Route::post('/general-data', [AssessmentController::class, 'storeGeneralData']);

                Route::get('/physio-data', [AssessmentController::class, 'showPhysioGuardianData']);
                Route::post('/physio-data', [PhysioAssessmentController::class, 'storeAssessmentGuardian']);

                Route::get('/speech-data', [AssessmentController::class, 'showSpeechGuardianData']);
                Route::post('/speech-data', [SpeechAssessmentController::class, 'storeAssessmentGuardian']);

                Route::get('/occupational-data', [AssessmentController::class, 'showOccupationalGuardianData']);
                Route::post('/occupational-data', [OccupationalAssessmentController::class, 'storeAssessmentGuardian']);

                Route::get('/pedagogical-data', [AssessmentController::class, 'showPedagogicalGuardianData']);
                Route::post('/pedagogical-data', [PedagogicalAssessmentController::class, 'storeAssessmentGuardian']);
            });
        });

        Route::middleware(['role:admin', 'throttle:admin'])->group(function () {
            Route::put('/admins/update-password', [AdminController::class, 'updatePassword']);
            Route::apiResource('/admins', AdminController::class);
            Route::apiResource('/therapists', TherapistController::class);

            Route::get('/children', [ChildController::class, 'index']);
            Route::get('/children/{child}', [ChildController::class, 'show']);

            Route::put('/observations/{observation}', [ObservationController::class, 'update']);
        });

        Route::get('/observations', [ObservationController::class, 'index']);

        Route::middleware(['role:terapis', 'throttle:therapist'])->group(
            function () {
                Route::get('/observations/{observation}', [ObservationController::class, 'show']);
                Route::post('/observations/{observation}/submit', [ObservationController::class, 'submit']);
                Route::put('/observations/{observation}/agreement', [ObservationController::class, 'assessmentAgreement']);
            }
        );

        Route::middleware('role:owner')->group(function () {
            Route::get('/admins/unverified', [OwnerController::class, 'indexAdmin']);
            Route::get('/therapists/unverified', [OwnerController::class, 'indexTherapist']);
            Route::get('/users/{user}/activate', [OwnerController::class, 'activateAccount']);
        });
    });
});
