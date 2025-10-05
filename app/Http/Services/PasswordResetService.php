<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Exception;

class PasswordResetService
{
    protected $userRepository;
    public const RESEND_COOLDOWN_MINUTES = 2;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendResetLinkEmail(string $email): array
    {
        $user = $this->userRepository->getByIdentifier($email);

        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan');
        }

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
        $user = $this->userRepository->getByIdentifier($email);
        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan');
        }

        $this->checkRateLimits($email);

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->recordResendAttempt($email);

            return [
                'email' => $email,
                'can_resend' => false,
                'cooldown_minutes' => self::RESEND_COOLDOWN_MINUTES,
            ];
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
            return [
                'email' => $email,
            ];
        }

        throw new Exception('Token reset password tidak valid atau telah kedaluwarsa.');
    }

    public function canResend(string $email): bool
    {
        return !Cache::has($this->getCooldownCacheKey($email));
    }

    public function getRemainingCooldown(string $email): int
    {
        $ttl = Cache::get($this->getCooldownCacheKey($email) . '_ttl', 0);
        return max(0, $ttl - time());
    }

    // ================= Private Helpers ================= //

    private function checkRateLimits(string $email): void
    {
        $cooldownKey = $this->getCooldownCacheKey($email);

        if (Cache::has($cooldownKey)) {
            $remaining = $this->getRemainingCooldown($email);
            $minutes = ceil($remaining / 60);

            throw new Exception("Mohon tunggu {$minutes} menit sebelum meminta link reset password baru.");
        }

        $hourlyKey = $this->getHourlyCacheKey($email);
        $attempts = Cache::get($hourlyKey, 0);

        if ($attempts >= self::MAX_RESEND_ATTEMPTS_PER_HOUR) {
            throw new Exception('Anda telah mencapai batas maksimal permintaan reset password. Silakan coba lagi dalam 1 jam.');
        }
    }

    private function recordResendAttempt(string $email): void
    {
        $cooldownMinutes = self::RESEND_COOLDOWN_MINUTES;
        $cooldownKey = $this->getCooldownCacheKey($email);

        Cache::put($cooldownKey, true, now()->addMinutes($cooldownMinutes));
        Cache::put($cooldownKey . '_ttl', time() + ($cooldownMinutes * 60), now()->addMinutes($cooldownMinutes));

        $hourlyKey = $this->getHourlyCacheKey($email);
        Cache::put($hourlyKey, Cache::get($hourlyKey, 0) + 1, now()->addHour());
    }

    private function getCooldownCacheKey(string $email): string
    {
        return "password_reset_cooldown_" . md5($email);
    }

    private function getHourlyCacheKey(string $email): string
    {
        return "password_reset_hourly_" . md5($email);
    }
}
