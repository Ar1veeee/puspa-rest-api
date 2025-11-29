<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Http\Resources\AdminProfileResource;
use App\Http\Services\AdminService;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ResponseFormatter;

    protected $admin_service;

    public function __construct(AdminService $admin_service)
    {
        return $this->admin_service = $admin_service;
    }

    public function showProfile()
    {
        $user_id = Auth::id();
        $profile = $this->admin_service->getProfile($user_id);
        $response = new AdminProfileResource($profile);
        return $this->successResponse($response, 'Profile Admin', 200);
    }

    public function updateProfile(UpdateAdminProfileRequest $request, Admin $admin): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($admin->profile_picture && Storage::disk('public')->exists($admin->profile_picture)) {
                Storage::disk('public')->delete($admin->profile_picture);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('admins', $filename, 'public');
            $data['profile_picture'] = $path;
        }

        $this->admin_service->updateProfile($data, $admin);

        return $this->successResponse([], 'Profile Berhasil Diperbarui', 200);
    }
}
