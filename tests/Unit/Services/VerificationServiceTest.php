<?php

namespace Tests\Unit\Services;

use App\Exceptions\AlreadyVerifiedException;
use App\Exceptions\RateLimitExceededException;
use App\Models\User;
use App\Services\VerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class VerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    private VerificationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new VerificationService();
    }

    /** @test */
    public function verify_email_marks_email_as_verified_and_activates_user_when_hash_valid()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => null,
            'is_active' => false,
        ]);

        $validHash = sha1($user->email);
        $this->service->verifyEmail($user->id, $validHash);

        $user->refresh();

        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($user->is_active);
    }

    /** @test */
    public function verify_email_throws_invalid_argument_when_hash_invalid()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => null,
            'is_active' => false,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid verification link.');

        $this->service->verifyEmail($user->id, 'wrong-hash');
    }

    /** @test */
    public function verify_email_throws_already_verified_when_user_already_verified()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'is_active' => false,
        ]);

        $validHash = sha1($user->email);

        $this->expectException(AlreadyVerifiedException::class);
        $this->expectExceptionMessage('Email sudah terverifikasi.');

        $this->service->verifyEmail($user->id, $validHash);
    }

    /** @test */
    public function resend_verification_notification_sends_notification_and_hits_limiter_when_allowed()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 456;

        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(false);
        $user->shouldReceive('sendEmailVerificationNotification')->once();

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with('verify-email|456', 5)
            ->andReturn(false);

        RateLimiter::shouldReceive('hit')
            ->once()
            ->with('verify-email|456', 120);

        $this->service->resendVerificationNotification($user);

        $this->assertTrue(true);
    }

    /** @test */
    public function resend_verification_notification_throws_already_verified_when_already_verified()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class);
        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(true);

        $this->expectException(AlreadyVerifiedException::class);
        $this->expectExceptionMessage('Email sudah terverifikasi.');

        $this->service->resendVerificationNotification($user);
    }

    /** @test */
    public function resend_verification_notification_throws_rate_limit_exceeded_when_too_many_attempts()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 789;

        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(false);

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with('verify-email|789', 5)
            ->andReturn(true);

        RateLimiter::shouldReceive('availableIn')
            ->once()
            ->with('verify-email|789')
            ->andReturn(95);

        $this->expectException(RateLimitExceededException::class);
        $this->expectExceptionMessage('Anda telah mencapai batas maksimal permintaan. Silakan coba lagi dalam 95 detik.');

        $this->service->resendVerificationNotification($user);
    }

    /** @test */
    public function get_resend_status_returns_correct_data()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 999;
        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(false);

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with('verify-email|999', 5)
            ->andReturn(false);

        RateLimiter::shouldReceive('availableIn')
            ->once()
            ->with('verify-email|999')
            ->andReturn(60);

        $result = $this->service->getResendStatus($user);

        $this->assertSame([
            'is_verified' => false,
            'can_resend' => true,
            'remaining_seconds' => 60,
        ], $result);
    }

    /** @test */
    public function get_resend_status_returns_can_resend_false_when_rate_limited()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 111;
        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(false);

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with('verify-email|111', 5)
            ->andReturn(true);

        RateLimiter::shouldReceive('availableIn')
            ->once()
            ->with('verify-email|111')
            ->andReturn(45);

        $result = $this->service->getResendStatus($user);

        $this->assertSame([
            'is_verified' => false,
            'can_resend' => false,
            'remaining_seconds' => 45,
        ], $result);
    }

    /** @test */
    public function get_resend_status_returns_is_verified_true_when_already_verified()
    {
        /** @var User&MockInterface $user */
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 222;
        $user->shouldReceive('hasVerifiedEmail')->once()->andReturn(true);

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with('verify-email|222', 5)
            ->andReturn(false);

        RateLimiter::shouldReceive('availableIn')
            ->once()
            ->with('verify-email|222')
            ->andReturn(null);

        $result = $this->service->getResendStatus($user);

        $this->assertSame([
            'is_verified' => true,
            'can_resend' => true,
            'remaining_seconds' => null,
        ], $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
