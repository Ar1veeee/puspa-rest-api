<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Services\VerificationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Tests\TestCase;

class VerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected VerificationService $verificationService;
    protected User $unverifiedUser;
    protected User $verifiedUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->verificationService = new VerificationService(new UserRepository(new User()));

        $this->unverifiedUser = User::factory()->unverified()->create();

        $this->verifiedUser = User::factory()->create();
    }


    /**
     * @test
     * Testing verification email success with valid signature URL.
     */
    public function verifyEmailShouldSucceedWithValidSignature(): void
    {
        $this->assertNull($this->unverifiedUser->email_verified_at);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->unverifiedUser->getKey(), 'hash' => sha1($this->unverifiedUser->getEmailForVerification())]
        );

        $request = Request::create($verificationUrl);
        $this->swap('request', $request);

        $this->verificationService->verifyEmail($this->unverifiedUser->id);

        $this->unverifiedUser->refresh();
        $this->assertNotNull($this->unverifiedUser->email_verified_at);
    }

    /**
     * @test
     * Testing verification email failed because invalid signature URL.
     */
    public function verifyEmailShouldThrowExceptionForInvalidSignature(): void
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Tautan verifikasi tidak valid atau kadaluwarsa. Silakan minta tautan baru.');

        $invalidUrl = route('verification.verify', ['id' => $this->unverifiedUser->id, 'hash' => 'invalid-hash']);
        $request = Request::create($invalidUrl);
        $this->swap('request', $request);

        $this->verificationService->verifyEmail($this->unverifiedUser->id);
    }

    /**
     * @test
     * Testing resend verification notification should succeed for unverified user.
     */
    public function resendVerificationNotificationShouldSucceedForUnverifiedUser(): void
    {
        Notification::fake();

        $result = $this->verificationService->resendVerificationNotification($this->unverifiedUser->id);

        $this->assertEquals(202, $result['status']);
        $this->assertEquals('Link verifikasi baru telah dikirim!', $result['message']);

        Notification::assertSentTo(
            $this->unverifiedUser,
            EmailVerificationNotification::class
        );
    }

    /**
     * @test
     * Testing verification not send when user already verified.
     */
    public function resendVerificationNotificationShouldReturnMessageForVerifiedUser(): void
    {
        Notification::fake();

        $result = $this->verificationService->resendVerificationNotification($this->verifiedUser->id);

        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Email sudah terverifikasi.', $result['message']);

        Notification::assertNothingSent();
    }

    /**
     * @test
     * Testing resend verification failed when user not found.
     */
    public function resendVerificationNotificationShouldThrowExceptionWhenUserNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Pengguna tidak ditemukan');

        $this->verificationService->resendVerificationNotification('non-existent-user-id');
    }
}
