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

        Route::get('/email-verify/{id}/{hash}', [VerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:verification'])
            ->name('verification.verify');

        Route::post('/resend-verification/{user_id}', [VerificationController::class, 'resendNotification'])
            ->name('verification.resend');

        Route::get('/resend-status/{user_id}', [VerificationController::class, 'checkResendStatus'])
            ->name('verification.status');

        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:login');

        Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
            ->middleware('throttle:forgot-password')
            ->name('password.email');

        Route::post('/resend-reset/{email}', [PasswordResetController::class, 'resendResetLink'])
            ->middleware('throttle:forgot-password')
            ->name('password.resend');

        Route::get('/resend-reset-status', [PasswordResetController::class, 'checkResendStatus'])
            ->name('password.resend.status');

        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
            ->name('password.reset')
            ->middleware('throttle:reset-password');
    });

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

    Route::middleware(['auth:sanctum', 'role:owner'])->group(
        function () {
            Route::get('/admins/unverified', [OwnerController::class, 'indexAdmin']);
            Route::get('/therapists/unverified', [OwnerController::class, 'indexTherapist']);
            Route::get('/users/verified/{user_id}', [OwnerController::class, 'activateAccount']);
        }
    );

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
            Route::get('/observations/answer/{observation_id}', [ObservationController::class, 'showDetailAnswer']);
            Route::get('/observations/completed', [ObservationController::class, 'indexCompleted']);
            Route::get('/observations/completed/{observation_id}', [ObservationController::class, 'showCompleted']);
            Route::put('/observations/assessment-agreement/{observation_id}', [ObservationController::class, 'assessmentAgreement']);
        }
    );

    Route::middleware(['auth:sanctum', 'role:user'])->group(
        function () {
            Route::get('/users/children', [GuardianController::class, 'indexChildren']);
            Route::post('/users/children', [GuardianController::class, 'storeChild']);

            Route::put('/users/identity', [GuardianController::class, 'update']);
            Route::get('/users/child-assessment', [AssessmentController::class, 'indexChildren']);
            Route::get('/users/child-assessment-detail/{assessment_id}', [AssessmentController::class, 'show']);
            Route::get('/users/child-assessment-general/{assessment_id}', [AssessmentController::class, 'showGeneralData']);
            Route::get('/users/child-assessment-physio-guardian/{assessment_id}', [AssessmentController::class, 'showPhysioGuardianData']);
            Route::get('/users/child-assessment-speech-guardian/{assessment_id}', [AssessmentController::class, 'showSpeechGuardianData']);
            Route::get('/users/child-assessment-occupational-guardian/{assessment_id}', [AssessmentController::class, 'showOccupationalGuardianData']);
            Route::get('/users/child-assessment-pedagogical-guardian/{assessment_id}', [AssessmentController::class, 'showPedagogicalGuardianData']);
            Route::post('/users/child-assessment-psychosocial/{assessment_id}', [AssessmentController::class, 'storeChildPsychosocial']);
            Route::post('/users/child-assessment-pregnancy/{assessment_id}', [AssessmentController::class, 'storeChildPregnancy']);
            Route::post('/users/child-assessment-birth/{assessment_id}', [AssessmentController::class, 'storeChildBirth']);
            Route::post('/users/child-assessment-post-birth/{assessment_id}', [AssessmentController::class, 'storeChildPostBirth']);
            Route::post('/users/child-assessment-health/{assessment_id}', [AssessmentController::class, 'storeChildHealth']);
            Route::post('/users/child-assessment-education/{assessment_id}', [AssessmentController::class, 'storeChildEducation']);
            Route::post('/users/child-assessment-physio/{assessment_id}', [PhysioAssessmentController::class, 'storeAssessmentGuardian']);
            Route::post('/users/child-assessment-speech/{assessment_id}', [SpeechAssessmentController::class, 'storeAssessmentGuardian']);
            Route::post('/users/child-assessment-occupational/{assessment_id}', [OccupationalAssessmentController::class, 'storeAssessmentGuardian']);
            Route::post('/users/child-assessment-pedagogical/{assessment_id}', [PedagogicalAssessmentController::class, 'storeAssessmentGuardian']);
        }
    );

});
