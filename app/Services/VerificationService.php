<?php

namespace App\Http\Services;

use App\Exceptions\AlreadyVerifiedException;
use App\Exceptions\RateLimitExceededException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use InvalidArgumentException;

class VerificationService
{
    public const RESEND_COOLDOWN_SECONDS = 120;
    private const MAX_RESEND_ATTEMPTS_PER_HOUR = 5;

    public function verifyEmail(string $userId, string $hash): void
    {
        $user = User::findOrFail($userId);

        if (!hash_equals(sha1($user->email), $hash)) {
            throw new InvalidArgumentException('Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            throw new AlreadyVerifiedException('Email sudah terverifikasi.');
        }

        $user->markEmailAsVerified();

        $user->update([
            'is_active' => true,
            'updated_at' => Carbon::now(),
        ]);
    }

    public function resendVerificationNotification(User $user): void
    {
        if ($user->hasVerifiedEmail()) {
            throw new AlreadyVerifiedException('Email sudah terverifikasi.');
        }

        $key = $this->rateLimiterKey($user);

        if (RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($key);
            throw new RateLimitExceededException("Anda telah mencapai batas maksimal permintaan. Silakan coba lagi dalam {$seconds} detik.");
        }

        $user->sendEmailVerificationNotification();

        RateLimiter::hit($key, self::RESEND_COOLDOWN_SECONDS);
    }

    public function getResendStatus(User $user): array
    {
        $key = $this->rateLimiterKey($user);

        return [
            'is_verified'       => $user->hasVerifiedEmail(),
            'can_resend'        => !RateLimiter::tooManyAttempts($key, self::MAX_RESEND_ATTEMPTS_PER_HOUR),
            'remaining_seconds' => RateLimiter::availableIn($key),
        ];
    }

    private function rateLimiterKey(User $user): string
    {
        return 'verify-email|' . $user->id;
    }
}
