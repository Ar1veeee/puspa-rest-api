<?php

namespace App\Http\Controllers\Assessor_Therapist;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateTherapistOrAssessorProfileRequest;
use App\Http\Resources\TherapistOrAssessorProfileResource;
use App\Models\Therapist;
use App\Services\TherapistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ResponseFormatter;

    protected $therapistService;

    public function __construct(TherapistService $therapistService)
    {
        return $this->therapistService = $therapistService;
    }

    public function showProfile()
    {
        $user_id = Auth::id();
        $profile = $this->therapistService->getProfile($user_id);
        $response = new TherapistOrAssessorProfileResource($profile);
        return $this->successResponse($response, 'Profile Admin', 200);
    }

    public function updateProfile(UpdateTherapistOrAssessorProfileRequest $request, Therapist $therapist): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($therapist->profile_picture && Storage::disk('public')->exists($therapist->profile_picture)) {
                Storage::disk('public')->delete($therapist->profile_picture);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('therapists', $filename, 'public');
            $data['profile_picture'] = $path;
        }

        $this->therapistService->updateProfile($data, $therapist);

        return $this->successResponse([], 'Profile Berhasil Diperbarui', 200);
    }
}
