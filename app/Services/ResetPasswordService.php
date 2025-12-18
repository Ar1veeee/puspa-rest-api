<?php

namespace App\Services;

use App\Exceptions\RateLimitExceededException;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

class ResetPasswordService
{
    public const RESEND_COOLDOWN_SECONDS = 120;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function sendResetLinkEmail(string $email): array
    {
        $status = Password::sendResetLink(['email' => $email]);

        return match ($status) {
            Password::RESET_LINK_SENT => ['status' => 'success'],
            Password::INVALID_USER    => throw new Exception('Pengguna tidak ditemukan.'),
            default                   => throw new Exception('Gagal mengirim link reset password.'),
        };
    }

    public function resendResetLink(string $email): void
    {
        $this->checkRateLimit($email);

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            RateLimiter::hit($this->limiterKey($email), self::RESEND_COOLDOWN_SECONDS);
            return;
        }

        throw new Exception('Gagal mengirim ulang tautan reset password.');
    }

    public function resetPassword(string $token, string $email, string $password): array
    {
        $status = Password::reset(
            [
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password,
                'token' => $token,
            ],
            function ($user) use ($password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            RateLimiter::clear($this->limiterKey($email));
            return ['status' => 'success'];
        }

        throw new Exception('Token reset password tidak valid atau telah kedaluwarsa.');
    }

    private function limiterKey(string $email): string
    {
        return 'password-reset|' . md5(strtolower($email));
    }

    private function checkRateLimit(string $email): void
    {
        $key = $this->limiterKey($email);

        if (RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($key);
            throw new RateLimitExceededException(
                "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik."
            );
        }
    }
}
