<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\UserRepository;
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

    public function activateAccount($id)
    {
        return $this->userRepository->activation($id);
    }
}
