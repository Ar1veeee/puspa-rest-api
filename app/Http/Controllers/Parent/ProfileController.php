<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateGuardianProfileRequest;
use App\Http\Resources\GuardianProfileResource;
use App\Models\Guardian;
use App\Services\GuardianService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ResponseFormatter;

    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        return $this->guardianService = $guardianService;
    }

    public function showProfile()
    {
        $user_id = Auth::id();
        $profile = $this->guardianService->getProfile($user_id);
        $response = new GuardianProfileResource($profile);
        return $this->successResponse($response, 'Profile', 200);
    }

    public function updateProfile(UpdateGuardianProfileRequest $request, Guardian $guardian): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($guardian->profile_picture && Storage::disk('public')->exists($guardian->profile_picture)) {
                Storage::disk('public')->delete($guardian->profile_picture);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('guardians', $filename, 'public');
            $data['profile_picture'] = $path;
        }

        $this->guardianService->updateProfile($guardian, $data);

        return $this->successResponse([], 'Profile Berhasil Diperbarui', 200);
    }
}
