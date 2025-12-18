<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Http\Resources\AdminProfileResource;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ResponseFormatter;

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        return $this->adminService = $adminService;
    }

    public function showProfile()
    {
        $userId = Auth::id();
        $profile = $this->adminService->getProfile($userId);
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

        $this->adminService->updateProfile($data, $admin);

        return $this->successResponse([], 'Profile Berhasil Diperbarui', 200);
    }
}
