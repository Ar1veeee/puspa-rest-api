<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OwnerService
{
    public function getAllAdminUnverified(): Collection
    {
        return User::unverifiedAdmins()->get();
    }

    public function getAllTherapistUnverified(): Collection
    {
        return User::unverifiedTherapists()->get();
    }

    public function promoteToAssessor(User $user): User
    {
        $user->syncRoles(['asesor']);
        return $user;
    }

    public function activateAccount(User $user)
    {
        $user->forceFill([
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
        ])->save();

        return $user->fresh();
    }

    public function deleteAccount(User $user)
    {
        $user->delete();
    }
}
