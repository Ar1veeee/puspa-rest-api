<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendResetLinkEmail(string $email): array
    {
        $user = $this->userRepository->getByIdentifier($email);

        if (! $user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan');
        }

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'status' => 200,
                'success' => true,
                'message' => 'Tautan reset password telah dikirim ke email Anda.',
                'data' => [],
            ];
        }

        return [
            'status' => 400,
            'success' => false,
            'message' => 'Gagal mengirim tautan reset password.',
            'data' => [],
        ];
    }

    public function resetPassword(string $token, string $email, string $password): array
    {
        $status = Password::reset(
            ['email' => $email, 'token' => $token, 'password' => $password],
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return [
                'status' => 200,
                'success' => true,
                'message' => 'Password berhasil diatur ulang. Silakan login.',
                'data' => [],
            ];
        }

        return [
            'status' => 400,
            'success' => false,
            'message' => 'Token reset password tidak valid atau telah kedaluwarsa.',
            'data' => [],
        ];
    }
}
