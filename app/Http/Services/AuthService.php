<?php

namespace App\Http\Services;

use App\Actions\Auth\ChangePasswordAction;
use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function register(array $data): User
    {
        return (new RegisterUserAction)->execute($data);
    }

    public function login(array $data): array
    {
        return (new LoginUserAction)->execute($data);
    }

    public function changePassword(
        User $user,
        string $currentPassword,
        string $newPassword,
        ?string $bearerToken = null
    ): void {
        $currentToken = $bearerToken
            ? PersonalAccessToken::findToken($bearerToken)
            : $user->currentAccessToken();

        (new ChangePasswordAction)->execute($user, $currentPassword, $newPassword, $currentToken);
    }

    public function logout(): void
    {
        (new LogoutUserAction)->execute();
    }
}
