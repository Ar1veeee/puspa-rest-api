<?php

namespace App\Http\Services;

use App\Exceptions\AlreadyVerifiedException;
use App\Exceptions\RateLimitExceededException;
use App\Http\Repositories\UserRepository;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class VerificationService
{
    protected UserRepository $userRepository;

    public const RESEND_COOLDOWN_SECONDS = 120;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyEmail(string $userId, string $hash): void
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan.');
        }

        if (!hash_equals(sha1($user->email), $hash)) {
            throw new ModelNotFoundException('Link verifikasi tidak valid.');
        }

        if ($user->email_verified_at !== null) {
            throw new AlreadyVerifiedException('Email sudah terverifikasi sebelumnya.');
        }

        DB::table('users')
            ->where('id', $userId)
            ->update([
                'email_verified_at' => now(),
                'is_active' => true,
                'updated_at' => now(),
            ]);

        $user->refresh();

        event(new Verified($user));
    }


    /**
     *
     * @param string $userId
     * @return void
     * @throws ModelNotFoundException If user not found.
     * @throws AlreadyVerifiedException If email already verified.
     * @throws RateLimitExceededException If the user exceeds the rate limit.
     */
    public function resendVerificationNotification(User $user): void
    {
        if ($user->hasVerifiedEmail()) {
            throw new AlreadyVerifiedException('Email sudah terverifikasi.');
        }

        $this->checkRateLimits($user->id);

        $user->sendEmailVerificationNotification();

        RateLimiter::hit($this->getLimiterKey($user->id), self::RESEND_COOLDOWN_SECONDS);
    }

    public function getResendStatus(User $user): array
    {
        $key = $this->getLimiterKey($user->id);

        return [
            'is_verified' => $user->hasVerifiedEmail(),
            'can_resend' => !RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR),
            'remaining_seconds' => RateLimiter::availableIn($key),
        ];
    }

    // ========== Private Helper Methods ==========

    private function getLimiterKey(string $userId): string
    {
        return "email-verification|{$userId}";
    }

    private function checkRateLimits(string $userId): void
    {
        $key = $this->getLimiterKey($userId);

        if (RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($key);
            throw new RateLimitExceededException("Anda telah mencapai batas maksimal permintaan. Silakan coba lagi dalam {$seconds} detik.");
        }
    }
}
