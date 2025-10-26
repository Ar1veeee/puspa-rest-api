<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OwnerService
{
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
    )
    {
        $this->userRepository = $userRepository;
    }

    public function getAllAdminUnverified(): Collection
    {
        return $this->userRepository->getAllAdminUnverified();
    }

    public function getAllTherapistUnverified(): Collection
    {
        return $this->userRepository->getAllTherapistUnverified();
    }

    public function promoteToAssessor(User $user)
    {
        return $this->userRepository->update([
            'role' => 'asesor'
        ], $user->id);
    }

    public function activateAccount(User $user)
    {
        return $this->userRepository->update([
            'is_active' => 1,
            'email_verified_at' => Carbon::now()
        ],$user->id);
    }
}
