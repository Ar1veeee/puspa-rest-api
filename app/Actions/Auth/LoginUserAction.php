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

        if (!$user || !Hash::check($password, $user->password)) {
            throw new AuthenticationException('Username atau email dan password tidak cocok.');
        }

        if (!$user->is_active) {
            throw new AuthenticationException('Akun Anda belum aktif.');
        }

        $token = $user->createToken(
            'api-token',
            ['*'],
            Carbon::now()->addDays(2)
        );

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
}
