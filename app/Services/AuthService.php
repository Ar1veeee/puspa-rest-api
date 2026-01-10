<?php

namespace App\Services;

use App\Actions\Auth\ChangePasswordAction;
use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function __construct(
        private RegisterUserAction $registerAction,
        private LoginUserAction $loginAction,
        private ChangePasswordAction $changePasswordAction,
        private LogoutUserAction $logoutAction
    ) {}

    public function register(array $data): User
    {
        return $this->registerAction->execute($data);
    }

    public function login(array $data): array
    {
        return $this->loginAction->execute($data);
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

        $this->changePasswordAction->execute($user, $currentPassword, $newPassword, $currentToken);
    }

    public function logout(): void
    {
        $this->logoutAction->execute();
    }
}
