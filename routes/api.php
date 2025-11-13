<?php

use App\Http\Controllers\Owner\EmployeeController as OwnerEmployeeManagement;

use App\Http\Controllers\Owner_Admin\UserController as OwnerAdminUserManagement;

use App\Http\Controllers\Admin\UserController as AdminUserManagement;
use App\Http\Controllers\Admin\ObservationController as AdminObservationManagement;
use App\Http\Controllers\Admin\AssessmentController as AdminAssessmentManagement;

use App\Http\Controllers\Admin_Assessor_Therapist\ObservationController as AdminAssessorTherapistObservationManagement;

use App\Http\Controllers\Assessor_Therapist\ObservationController as AssessorTherapistObservationManagement;

use App\Http\Controllers\Assessor\AssessmentController as AssessorAssessmentManagement;

use App\Http\Controllers\Parent\ProfileController as ParentProfileManagement;
use App\Http\Controllers\Parent\ChildController as ParentChildManagement;

use App\Http\Controllers\Parent\AssessmentController as ParentAssessmentManagement;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // ================== ROUTE UNAUTHENTICATED ==================
    Route::get('/cors-test', function () {
        return response()->json(['message' => 'CORS test successful!']);
    });

    Route::get('/test-paths', function () {
        return response()->json([
            'public_path' => public_path(),
            'storage_link' => public_path('storage'),
            'real_path' => realpath(public_path('storage')),
            'storage_app_public' => storage_path('app/public'),
            'config_public_root' => config('filesystems.disks.public.root'),
            'symlink_exists' => is_link(public_path('storage')),
            'symlink_target' => is_link(public_path('storage')) ? readlink(public_path('storage')) : null,
            'can_write' => is_writable(storage_path('app/public')),
        ]);
    });

    Route::get('/clear-cache', function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');

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

        Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])
            ->middleware('throttle:forgot-password')
            ->name('password.email');
        Route::post('/resend-reset/{email}', [ResetPasswordController::class, 'resendResetLink'])
            ->middleware('throttle:forgot-password')
            ->name('password.resend');
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
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
            Route::get('/users/{type}/unverified', [OwnerEmployeeManagement::class, 'indexUnverified']);
            Route::get('/users/{user}/promote-to-assessor', [OwnerEmployeeManagement::class, 'promoteToAssessor']);
            Route::get('/users/{user}/activate', [OwnerEmployeeManagement::class, 'activateAccount']);
        });

        // ================== ROLE OWNER & ADMIN ==================
        Route::middleware(['role:admin,owner', 'throttle:authenticated'])->group(function () {
            Route::get('/admins', [OwnerAdminUserManagement::class, 'indexAdmin']);
            Route::get('/therapists', [OwnerAdminUserManagement::class, 'indexTherapist']);
            Route::get('/children', [OwnerAdminUserManagement::class, 'indexChild']);
        });

        // ================== ROLE ADMIN ==================
        Route::middleware(['role:admin', 'throttle:authenticated'])->group(function () {
            Route::put('/admins/update-password', [AdminUserManagement::class, 'updatePasswordAdmin']);

            Route::get('/admins/{admin}', [AdminUserManagement::class, 'showAdminDetail']);
            Route::post('/admins', [AdminUserManagement::class, 'storeAdmin']);
            Route::put('/admins/{admin}', [AdminUserManagement::class, 'updateAdmin']);
            Route::delete('/admins/{admin}', [AdminUserManagement::class, 'destroyAdmin']);

            Route::get('/therapists/{therapist}', [AdminUserManagement::class, 'showTherapistDetail']);
            Route::post('/therapists', [AdminUserManagement::class, 'storeTherapist']);
            Route::put('/therapists/{therapist}', [AdminUserManagement::class, 'updateTherapist']);
            Route::delete('/therapists/{therapist}', [AdminUserManagement::class, 'destroyTherapist']);

            Route::get('/children/{child}', [AdminUserManagement::class, 'showChild']);
            Route::put('/children/{child}', [AdminUserManagement::class, 'updateChild']);

            Route::put('/observations/{observation}', [AdminObservationManagement::class, 'updateObservationDate']);
            Route::get('/observations/scheduled', [AdminObservationManagement::class, 'indexScheduledByDate']); // using query: date
            Route::put('/observations/{observation}/agreement', [AdminObservationManagement::class, 'assessmentAgreement']);
        });

        // ================== ROLE ADMIN, THERAPIST, ASSESSOR ==================
        Route::middleware(['role:admin,terapis,asesor', 'throttle:authenticated'])->group(function () {
            Route::get('/observations', [AdminAssessorTherapistObservationManagement::class, 'indexByStatus']); // using query: status
            Route::get('/observations/{observation}', [AdminAssessorTherapistObservationManagement::class, 'showByType']); // using query: type
        });

        // ================== ROLE THERAPIST & ASSESSOR ==================
        Route::middleware(['role:terapis,asesor', 'throttle:authenticated'])->group(function () {
            Route::post('/observations/{observation}/submit', [AssessorTherapistObservationManagement::class, 'submit']);
        });

        // ================== ROLE ASSESSOR ==================
        Route::middleware(['role:admin,asesor', 'throttle:authenticated'])->group(function () {
            Route::prefix('assessments')->group(function () {
                Route::get('/scheduled', [AdminAssessmentManagement::class, 'indexScheduledByDate']); // using query: date
                Route::get('/{status}', [AssessorAssessmentManagement::class, 'indexByStatus'])
                    ->whereIn('type', ['fisio', 'okupasi', 'wicara', 'paedagog']); // using query: type
                Route::post('/{assessment}', [AssessorAssessmentManagement::class, 'storeTherapistAssessment']);
                Route::get('/{assessment}/answer', [AssessorAssessmentManagement::class, 'showTherapistAssessmentAnswer']);
            });
        });

        // ================== ROLE ORANG TUA / USER ==================
        Route::middleware(['verified', 'role:user', 'throttle:authenticated'])->prefix('my')->group(function () {
            Route::get('/profile', [ParentProfileManagement::class, 'showProfile']);
            Route::post('/profile/{guardian}', [ParentProfileManagement::class, 'updateProfile']);
            Route::put('/update-password', [ParentProfileManagement::class, 'updatePassword']);

            Route::get('/children', [ParentChildManagement::class, 'indexChildren']);
            Route::post('/children', [ParentChildManagement::class, 'storeChild']);

            // Untuk menyimpan data lengkap ortu Ayah, Ibu, & Wali (Termasuk di Data Umum)
            Route::put('/identity', [ParentAssessmentManagement::class, 'updateFamilyData']);

            // Untuk menampilkan asasmen terjadwal milik anak
            Route::get('/assessments', [ParentAssessmentManagement::class, 'indexChildrenAssessment']);

            Route::prefix('assessments/{assessment}')->group(function () {
                Route::get('/', [ParentAssessmentManagement::class, 'show']);
                Route::post('/', [ParentAssessmentManagement::class, 'storeGuardianAssessment']);
                Route::get('/answer', [ParentAssessmentManagement::class, 'showGuardianAssessmentAnswer']);
            });
        });
    });
});
