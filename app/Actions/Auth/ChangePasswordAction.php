<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class ChangePasswordAction
{
    public function execute(
        User $user,
        string $currentPassword,
        $newPassword,
        PersonalAccessToken $currentToken
    ): void {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        DB::transaction(function () use ($user, $newPassword, $currentToken) {
            $user->update(['password' => Hash::make($newPassword)]);

            if ($currentToken) {
                $currentToken->delete();
            }
        });
    }
}
