<?php

use App\Http\Controllers\Admin\ProfileController as AdminProfileManagement;
use App\Http\Controllers\Admin\ObservationController as AdminObservationManagement;
use App\Http\Controllers\Admin\UserController as AdminUserManagement;
use App\Http\Controllers\Admin\AssessmentController as AdminAssessmentManagement;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin_Assessor\AssessmentController as AdminAssessorAssessmentManagement;
use App\Http\Controllers\Admin_Assessor_Therapist\ObservationController as AdminAssessorTherapistObservationManagement;
use App\Http\Controllers\Assessor\AssessmentController as AssessorAssessmentManagement;
use App\Http\Controllers\Assessor_Therapist\ObservationController as AssessorTherapistObservationManagement;
use App\Http\Controllers\Assessor_Therapist\ProfileController as AssessorTherapistProfileManagement;
use App\Http\Controllers\Assessor_Therapist\DashboardController as AssessorTherapistDashboard;
use App\Http\Controllers\Owner\EmployeeController as OwnerEmployeeManagement;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner_Admin\UserController as OwnerAdminUserManagement;
use App\Http\Controllers\Parent\AssessmentController as ParentAssessmentManagement;
use App\Http\Controllers\Parent\ChildController as ParentChildManagement;
use App\Http\Controllers\Parent\ProfileController as ParentProfileManagement;
use App\Http\Controllers\Parent\DashboardController as ParentDashboard;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
    Route::post('/register', [AuthController::class, 'register']);
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

    Route::put('/profile/update-password', [AuthController::class, 'updatePassword']);


    // ================== ROLE OWNER ==================
    Route::middleware(['role:owner', 'throttle:authenticated'])->group(function () {
        Route::get('/owners/dashboard', [OwnerDashboard::class, 'index']);
        Route::get('/users/{type}/unverified', [OwnerEmployeeManagement::class, 'indexUnverified'])
            ->whereIn('type', ['admin', 'therapist']);
        Route::get('/users/{user}/promote-to-assessor', [OwnerEmployeeManagement::class, 'promoteToAssessor'])
            ->whereUlid('user', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::get('/users/{user}/activate', [OwnerEmployeeManagement::class, 'activateAccount'])
            ->whereUlid('user', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::get('/users/{user}/deactive', [OwnerEmployeeManagement::class, 'deleteAccount'])
            ->whereUlid('user', '[0-9A-HJ-NP-TV-Z]{26}');
    });

    // ================== ROLE OWNER & ADMIN ==================
    Route::middleware(['role:admin|owner', 'throttle:authenticated'])->group(function () {
        Route::get('/admins', [OwnerAdminUserManagement::class, 'indexAdmin']);
        Route::get('/admins/{admin}', [AdminUserManagement::class, 'showAdminDetail'])
            ->whereUlid('admin', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::get('/therapists', [OwnerAdminUserManagement::class, 'indexTherapist']);
        Route::get('/therapists/{therapist}', [AdminUserManagement::class, 'showTherapistDetail'])
            ->whereUlid('therapist', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::get('/children', [OwnerAdminUserManagement::class, 'indexChild']);
        Route::get('/children/{child}', [AdminUserManagement::class, 'showChild'])
            ->whereUlid('child', '[0-9A-HJ-NP-TV-Z]{26}');
    });

    // ================== ROLE ADMIN ==================
    Route::middleware(['role:admin', 'throttle:authenticated'])->group(function () {
        Route::get('/admins/dashboard/stats', [AdminDashboard::class, 'index']);
        Route::get('/admins/dashboard/today-schedule', [AdminDashboard::class, 'todayTherapySchedule']);
        Route::get('/admins/profile', [AdminProfileManagement::class, 'showProfile']);
        Route::post('/admins/{admin}/profile', [AdminProfileManagement::class, 'updateProfile'])
            ->whereUlid('admin', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::post('/admins', [AdminUserManagement::class, 'storeAdmin']);
        Route::put('/admins/{admin}', [AdminUserManagement::class, 'updateAdmin'])
            ->whereUlid('admin', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::delete('/admins/{admin}', [AdminUserManagement::class, 'destroyAdmin'])
            ->whereUlid('admin', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::post('/therapists', [AdminUserManagement::class, 'storeTherapist']);
        Route::put('/therapists/{therapist}', [AdminUserManagement::class, 'updateTherapist'])
            ->whereUlid('therapist', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::delete('/therapists/{therapist}', [AdminUserManagement::class, 'destroyTherapist'])
            ->whereUlid('therapist', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::put('/children/{child}', [AdminUserManagement::class, 'updateChild'])
            ->whereUlid('child', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::put('/observations/{observation}', [AdminObservationManagement::class, 'updateObservationDate'])
            ->whereNumber('observation');
        Route::put('/observations/{observation}/agreement', [AdminObservationManagement::class, 'assessmentAgreement'])
            ->whereNumber('observation');

        Route::get('/assessments/{status}/admin', [AdminAssessmentManagement::class, 'indexAssessments'])
            ->whereIn('status', ['scheduled', 'completed']); // using query filter: date, and search
    });

    // ================== ROLE ADMIN, THERAPIST, ASSESSOR ==================
    Route::middleware(['role:admin|terapis|asesor', 'throttle:authenticated'])->group(function () {
        // for status pending using query: search
        // for status scheduled & completed using query: date, search
        Route::get('/observations/{status}', [AdminAssessorTherapistObservationManagement::class, 'indexByStatus'])
            ->whereIn('status', ['pending', 'scheduled', 'completed']);
        Route::get('/observations/{observation}/detail', [AdminAssessorTherapistObservationManagement::class, 'showDetailByType'])
            ->whereNumber('observation')
            ->whereIn('type', ['scheduled', 'completed', 'question', 'answer']);
    });

    // ================== ROLE THERAPIST & ASSESSOR ==================
    Route::middleware(['role:terapis|asesor', 'throttle:authenticated'])->group(function () {
        Route::get('/asse-thera/dashboard', [AssessorTherapistDashboard::class, 'index']);
        Route::get('/asse-thera/profile', [AssessorTherapistProfileManagement::class, 'showProfile']);
        Route::post('/asse-thera/{therapist}/profile', [AssessorTherapistProfileManagement::class, 'updateProfile'])
            ->whereUlid('therapist', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::get('/asse-thera/upcoming-schedules', [AssessorTherapistDashboard::class, 'upcomingSchedules']);
        Route::post('/observations/{observation}/submit', [AssessorTherapistObservationManagement::class, 'submit'])
            ->whereNumber('observation');
    });

    // ================== ROLE ASSESSOR & ADMIN ==================
    Route::middleware(['role:admin|asesor', 'throttle:authenticated'])->group(function () {
        Route::prefix('assessments')->group(function () {
            Route::patch('/{assessment}', [AdminAssessmentManagement::class, 'updateAssessmentDate'])
                ->whereNumber('assessment');
            Route::get('/{assessment}/detail', [AdminAssessorAssessmentManagement::class, 'showDetailScheduled'])
                ->whereNumber('assessment');
            Route::post('/{assessment}/report-upload', [AdminAssessorAssessmentManagement::class, 'uploadReportFile'])
                ->whereNumber('assessment');
            Route::get('/{assessment}/answer/{type}', [AdminAssessorAssessmentManagement::class, 'indexAnswersAssessment'])
                ->whereNumber('assessment')
                ->whereIn('type', [
                    'paedagog_assessor',
                    'wicara_assessor',
                    'fisio_assessor',
                    'okupasi_assessor',
                    'umum_parent',
                    'wicara_parent',
                    'paedagog_parent',
                    'okupasi_parent',
                    'fisio_parent'
                ]);
        });
    });

    // ================== ROLE ASSESSOR ==================
    Route::middleware(['role:asesor', 'throttle:authenticated'])->group(function () {
        Route::prefix('assessments')->group(function () {
            Route::get('/{status}', [AssessorAssessmentManagement::class, 'indexAssessmentsByType'])
                ->whereIn('status', ['scheduled', 'completed']); // using query filter: date, and search
            Route::get('/{type}/question', [AssessorAssessmentManagement::class, 'indexAssessorQuestionsByType'])
                ->whereIn('type', [
                    'paedagog',
                    'wicara_oral',
                    'wicara_bahasa',
                    'fisio',
                    'okupasi',
                    'parent_general',
                    'parent_wicara',
                    'parent_paedagog',
                    'parent_okupasi',
                    'parent_fisio'
                ]);
            Route::get('/{status}/parent', [AssessorAssessmentManagement::class, 'indexParentsAssessment'])
                ->whereIn('status', ['completed', 'pending']); // with query filter: date, search
            Route::post('/{assessment}/submit/{type}', [AssessorAssessmentManagement::class, 'storeAssessorAssessment'])
                ->whereNumber('assessment')
                ->whereIn('type', [
                    'paedagog_assessor',
                    'wicara_assessor',
                    'fisio_assessor',
                    'okupasi_assessor'
                ]);
        });
    });

    // ================== ROLE ORANG TUA / USER ==================
    Route::middleware(['verified', 'role:user', 'throttle:authenticated'])->prefix('my')->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/stats', [ParentDashboard::class, 'index']);
            Route::get('/chart', [ParentDashboard::class, 'chartData']);
            Route::get('/upcoming-schedules', [ParentDashboard::class, 'upcomingSchedules']);
        });
        
        Route::get('/profile', [ParentProfileManagement::class, 'showProfile']);
        Route::post('/profile/{guardian}', [ParentProfileManagement::class, 'updateProfile'])
            ->whereUlid('guardian', '[0-9A-HJ-NP-TV-Z]{26}');

        Route::get('/children', [ParentChildManagement::class, 'indexChildren']);
        Route::get('/children/{child}', [ParentChildManagement::class, 'showChild'])
            ->whereUlid('child', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::put('/children/{child}', [ParentChildManagement::class, 'updateChild'])
            ->whereUlid('child', '[0-9A-HJ-NP-TV-Z]{26}');
        Route::post('/children', [ParentChildManagement::class, 'storeChild']);

        // Untuk menyimpan data lengkap ortu Ayah, Ibu, & Wali (Termasuk di Data Umum)
        Route::put('/identity', [ParentAssessmentManagement::class, 'updateFamilyData']);

        // Untuk menampilkan asasmen terjadwal milik anak
        Route::get('/assessments', [ParentAssessmentManagement::class, 'indexChildrenAssessment']);

        Route::prefix('assessments')->group(function () {
            Route::get('/{type}/question', [ParentAssessmentManagement::class, 'indexParentQuestionsByType'])
                ->whereIn('type', [
                    'parent_general',
                    'parent_wicara',
                    'parent_paedagog',
                    'parent_okupasi',
                    'parent_fisio'
                ]);
            Route::post('/{assessment}/submit/{type}', [ParentAssessmentManagement::class, 'storeParentAssessment'])
                ->whereNumber('assessment')
                ->whereIn('type', [
                    'umum_parent',
                    'wicara_parent',
                    'paedagog_parent',
                    'okupasi_parent',
                    'fisio_parent'
                ]);
            Route::get('/{assessment}/answer/{type}', [ParentAssessmentManagement::class, 'indexAnswersAssessment'])
                ->whereNumber('assessment')
                ->whereIn('type', [
                    'umum_parent',
                    'wicara_parent',
                    'paedagog_parent',
                    'okupasi_parent',
                    'fisio_parent'
                ]);
            Route::get('/{assessment}/report-download', [ParentAssessmentManagement::class, 'downloadReportFile'])
                ->whereNumber('assessment')
                ->name('parent.assessment.report.download');
            Route::get('/{assessment}', [ParentAssessmentManagement::class, 'show'])
                ->whereNumber('assessment');
        });
    });
});
