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
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // ================== ROUTE UNAUTHENTICATED ==================
    Route::get('/cors-test', function () {
        return response()->json(['message' => 'CORS test successful!']);
    });

    Route::get('/test-paths', function () {
        return response()->json([
            'base_path' => base_path(),
            'app_path' => app_path(),
            'storage_path' => storage_path(),
            'public_path' => public_path(),
            'public_path_storage' => public_path('storage'),
            'config_root' => config('filesystems.disks.public.root'),
            'folder_exists' => file_exists(public_path('storage')),
            'is_writable' => is_writable(public_path('storage')),
        ]);
    });

    Route::get('/clear-cache', function () {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        \Artisan::call('route:clear');
        \Artisan::call('optimize:clear');

        // Force reload config
        config()->offsetUnset('filesystems');

        return response()->json([
            'success' => true,
            'public_path' => public_path(),
            'base_path' => base_path(),
            'storage_path' => public_path('storage'),
            'config_root' => config('filesystems.disks.public.root'),
        ]);
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

    // ================== ROUTE AUTHENTICATED ==================
    Route::middleware('auth:sanctum')->group(function () {
        // ================== GLOBAL ==================
        Route::post('/auth/logout', [AuthController::class, 'logout'])
            ->middleware('throttle:logout');
        Route::get('/auth/protected', [AuthController::class, 'protected']);

        // ================== ROLE OWNER ==================
        Route::middleware(['role:owner', 'throttle:authenticated'])->group(function () {
            Route::get('/users/{type}/unverified', [OwnerController::class, 'indexUnverified']);
            Route::get('/users/{user}/promote-to-assessor', [OwnerController::class, 'promoteToAssessor']);
            Route::get('/users/{user}/activate', [OwnerController::class, 'activateAccount']);
        });

        // ================== ROLE OWNER & ADMIN ==================
        Route::middleware(['role:admin,owner', 'throttle:authenticated'])->group(function () {
            Route::get('/admins', [AdminController::class, 'index']);
            Route::get('/therapists', [TherapistController::class, 'index']);
            Route::get('/children', [ChildController::class, 'index']);
        });

        // ================== ROLE ADMIN ==================
        Route::middleware(['role:admin', 'throttle:authenticated'])->group(function () {
            Route::put('/admins/update-password', [AdminController::class, 'updatePassword']);

            Route::get('/admins/{admin}', [AdminController::class, 'show']);
            Route::post('/admins', [AdminController::class, 'store']);
            Route::put('/admins/{admin}', [AdminController::class, 'update']);
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy']);

            Route::get('/therapists/{therapist}', [TherapistController::class, 'show']);
            Route::post('/therapists', [TherapistController::class, 'store']);
            Route::put('/therapists/{therapist}', [TherapistController::class, 'update']);
            Route::delete('/therapists/{therapist}', [TherapistController::class, 'destroy']);

            Route::get('/children/{child}', [ChildController::class, 'show']);
            Route::put('/children/{child}', [ChildController::class, 'update']);

            Route::put('/observations/{observation}', [ObservationController::class, 'updateObservationDate']);
            Route::put('/observations/{observation}/agreement', [ObservationController::class, 'assessmentAgreement']);
        });

        // ================== ROLE ADMIN, THERAPIST, ASSESSOR ==================
        Route::middleware(['role:admin,terapis,asesor', 'throttle:authenticated'])->group(function () {
            Route::get('/observations', [ObservationController::class, 'indexByStatus']); // status sebagai query
            Route::get('/observations/{observation}', [ObservationController::class, 'showByType']); // type sebagai query
        });

        // ================== ROLE THERAPIST & ASSESSOR ==================
        Route::middleware(['role:terapis,asesor', 'throttle:authenticated'])->group(function () {
            Route::post('/observations/{observation}/submit', [ObservationController::class, 'submit']);
        });

        // ================== ROLE ASSESSOR ==================
        Route::middleware(['role:asesor', 'throttle:authenticated'])->group(function () {
            Route::prefix('assessments')->group(function () {
                Route::get('/{status}', [AssessmentController::class, 'indexByStatus'])
                    ->whereIn('type', ['fisio', 'okupasi', 'wicara', 'paedagog']);
                Route::post('/{assessment}', [AssessmentController::class, 'storeTherapistAssessment']);
                Route::get('/{assessment}/answer', [AssessmentController::class, 'showTherapistAssessmentAnswer']);
            });
        });

        // ================== ROLE ORANG TUA / USER ==================
        Route::middleware(['verified', 'role:user', 'throttle:authenticated'])->prefix('my')->group(function () {
            Route::get('/profile', [GuardianController::class, 'showProfile']);
            Route::put('/profile/{guardian}', [GuardianController::class, 'updateProfile']);
            Route::put('/update-password', [GuardianController::class, 'updatePassword']);

            Route::get('/children', [GuardianController::class, 'indexChildren']);
            Route::post('/children', [GuardianController::class, 'storeChild']);

            // Untuk menyimpan data lengkap ortu Ayah, Ibu, & Wali (Termasuk di Data Umum)
            Route::put('/identity', [GuardianController::class, 'updateFamilyData']);

            // Untuk menampilkan asasmen terjadwal milik anak
            Route::get('/assessments', [AssessmentController::class, 'indexChildrenAssessment']);

            Route::prefix('assessments/{assessment}')->group(function () {
                Route::get('/', [AssessmentController::class, 'show']);
                Route::post('/', [AssessmentController::class, 'storeGuardianAssessment']);
                Route::get('/answer', [AssessmentController::class, 'showGuardianAssessmentAnswer']);
            });
        });
    });
});
