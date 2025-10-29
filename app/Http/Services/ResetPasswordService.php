<?php

namespace App\Http\Services;

use App\Exceptions\RateLimitExceededException;
use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Exception;

class PasswordResetService
{
    protected $userRepository;
    public const RESEND_COOLDOWN_SECONDS = 120;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendResetLinkEmail(string $email): array
    {
        $this->findUserOrFail($email);
        $status = Password::sendResetLink(['email' => $email]);
        if ($status === Password::RESET_LINK_SENT) {
            return [
                'email' => $email,
            ];
        }

        throw new Exception('Gagal mengirim tautan reset password.');
    }

    public function resendResetLink(string $email): array
    {
        $this->findUserOrFail($email);

        $this->checkRateLimits($email);

        $status = Password::sendResetLink(['email' => $email]);
        if ($status === Password::RESET_LINK_SENT) {
            RateLimiter::hit($this->getLimiterKey($email), self::RESEND_COOLDOWN_SECONDS);
            return ['email' => $email];
        }

        throw new Exception('Gagal mengirim ulang tautan reset password.');
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
            RateLimiter::clear($this->getLimiterKey($email));
            return ['email' => $email];
        }

        throw new Exception('Token reset password tidak valid atau telah kedaluwarsa.');
    }

    // ================= Private Helpers ================= //

    private function findUserOrFail(string $email)
    {
        $user = $this->userRepository->getByIdentifier($email);
        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan');
        }
        return $user;
    }

    private function getLimiterKey(string $email): string
    {
        return 'password-reset|' . md5(strtolower($email));
    }

    private function checkRateLimits(string $email): void
    {
        $key = $this->getLimiterKey($email);

        if (RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($key);
            throw new RateLimitExceededException("Anda telah mencapai batas maksimal permintaan. Silakan coba lagi dalam {$seconds} detik.");
        }
    }
}
