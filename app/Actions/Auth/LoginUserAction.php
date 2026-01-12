<?php

namespace App\Actions\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function execute(array $data): array
    {
        $identifier = $data['identifier'];
        $password = $data['password'];

        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        $targetUser = $user;
        if (!$targetUser) {
            $targetUser = new User();
            $targetUser->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        }

        $isValidPassword = Hash::check($password, $targetUser->password);

        if (!$user || !$isValidPassword) {
            throw new AuthenticationException('Username atau email dan password tidak cocok.');
        }

        if (!$user->is_active) {
            throw new AuthenticationException('Akun Anda belum aktif.');
        }

        $token = $user->createToken(
            'api-token',
            ['*'],
            Carbon::now()->addMinutes(120)
        );

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
}
