<?php

namespace App\Http\Services;

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
        $user->update(['role' => 'asesor']);
        return $user;
    }

    public function activateAccount(User $user)
    {
        return DB::transaction(function () use ($user) {
            $user->update([
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
            ]);

            return $user->fresh();
        });
    }

    public function deleteAccount(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });
    }
}
