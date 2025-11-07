<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddChildrenRequest;
use App\Http\Requests\GuardianFamilyUpdateRequest;
use App\Http\Requests\UpdateGuardianProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\ChildrenResource;
use App\Http\Resources\GuardianProfileResource;
use App\Http\Services\GuardianService;
use App\Models\Guardian;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuardianController extends Controller
{
    use ResponseFormatter;

    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        return $this->guardianService = $guardianService;
    }

    public function indexChildren(): JsonResponse
    {
        $userId = Auth::id();
        $children = $this->guardianService->getChildren($userId);
        $response = ChildrenResource::collection($children);

        return $this->successResponse($response, 'Daftar Anak', 200);
    }

    public function showProfile()
    {
        $user_id = Auth::id();
        $profile = $this->guardianService->getProfile($user_id);
        $response = new GuardianProfileResource($profile);
        return $this->successResponse($response, 'Profile', 200);
    }

    public function storeChild(AddChildrenRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $this->guardianService->addChild($userId, $data);

        return $this->successResponse([], 'Tambah Anak Berhasil', 201);
    }

    public function updateFamilyData(GuardianFamilyUpdateRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
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

        $this->guardianService->updateProfile($data, $guardian);

        return $this->successResponse([], 'Profile Berhasil Diperbarui', 200);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $this->guardianService->updatePassword($data, $userId);

        return $this->successResponse([], 'Password Berhasil Diperbarui', 200);
    }
}
