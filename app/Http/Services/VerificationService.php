<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Exception;

class VerificationService
{
    protected UserRepository $userRepository;

    public const RESEND_COOLDOWN_MINUTES = 2;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateHash(string $userId, string $hash): void
    {
        $user = $this->findUserOrFail($userId);

        if (!$this->isHashValid($user, $hash)) {
            throw new AuthorizationException('Tautan verifikasi tidak valid atau sudah kadaluarsa.');
        }
    }

    public function verifyEmail(string $userId): array
    {
        $user = $this->findUserOrFail($userId);

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Email sudah terverifikasi sebelumnya.',
            ];
        }

        $this->markUserAsVerified($user);

        return [
            'success' => true,
            'message' => 'Email berhasil diverifikasi.',
        ];
    }

    public function resendVerificationNotification(string $userId): array
    {
        $user = $this->findUserOrFail($userId);

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Email sudah terverifikasi.',
            ];
        }

        $this->checkRateLimits($userId);

        $user->sendEmailVerificationNotification();
        $this->recordResendAttempt($userId);

        return [
            'success' => true,
            'message' => "Link verifikasi baru telah dikirim ke email Anda. Tunggu " . self::RESEND_COOLDOWN_MINUTES . " menit sebelum meminta lagi.",
        ];
    }

    public function canResendVerification(string $userId): bool
    {
        return !Cache::has($this->getCooldownCacheKey($userId));
    }

    public function getRemainingCooldown(string $userId): int
    {
        $ttl = Cache::get($this->getCooldownCacheKey($userId) . '_ttl', 0);
        return max(0, $ttl - time());
    }

    // ========== Private Helper Methods ==========

    private function findUserOrFail(string $userId): User
    {
        $user = $this->userRepository->getById($userId);

        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan.');
        }

        return $user;
    }

    private function isHashValid(User $user, string $hash): bool
    {
        return hash_equals(sha1($user->getEmailForVerification()), $hash);
    }

    private function markUserAsVerified(User $user): void
    {
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    }

    public function checkRateLimits(string $userId): void
    {
        $cooldownKey = $this->getCooldownCacheKey($userId);

        if (Cache::has($cooldownKey)) {
            $remaining = $this->getRemainingCooldown($userId);
            $minutes = ceil($remaining / 60);

            throw new Exception("Mohon tunggu {$minutes} menit sebelum meminta link verifikasi baru.");
        }

        $hourlyKey = $this->getHourlyCacheKey($userId);
        $attempts = Cache::get($hourlyKey, 0);

        if ($attempts >= self::MAX_RESEND_ATTEMPTS_PER_HOUR) {
            throw new Exception('Anda telah mencapai batas maksimal permintaan verifikasi. Silakan coba lagi dalam 1 jam.');
        }
    }

    private function recordResendAttempt(string $userId): void
    {
        $cooldownMinutes = self::RESEND_COOLDOWN_MINUTES;
        $cooldownKey = $this->getCooldownCacheKey($userId);

        Cache::put($cooldownKey, true, now()->addMinutes($cooldownMinutes));
        Cache::put($cooldownKey . '_ttl', time() + ($cooldownMinutes * 60), now()->addMinutes($cooldownMinutes));

        $hourlyKey = $this->getHourlyCacheKey($userId);
        Cache::put($hourlyKey, Cache::get($hourlyKey, 0) + 1, now()->addHour());
    }

    private function getCooldownCacheKey(string $userId): string
    {
        return "verification_cooldown_{$userId}";
    }

    private function getHourlyCacheKey(string $userId): string
    {
        return "verification_hourly_{$userId}";
    }
}
