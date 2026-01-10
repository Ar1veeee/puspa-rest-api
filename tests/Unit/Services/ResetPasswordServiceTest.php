<?php

namespace Tests\Unit\Services;

use App\Exceptions\RateLimitExceededException;
use App\Services\ResetPasswordService;
use Exception;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ResetPasswordServiceTest extends TestCase
{
    private ResetPasswordService $service;

    /** @var PasswordBroker|MockInterface */
    private $passwordBrokerMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passwordBrokerMock = Mockery::mock(PasswordBroker::class);

        Password::swap($this->passwordBrokerMock);

        $this->service = new ResetPasswordService();
    }

    /** @test */
    public function send_reset_link_email_returns_success_when_link_sent()
    {
        $email = 'user@example.com';

        $this->passwordBrokerMock
            ->shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => $email])
            ->andReturn(Password::RESET_LINK_SENT);

        $result = $this->service->sendResetLinkEmail($email);

        $this->assertIsArray($result);
        $this->assertEquals(['status' => 'success'], $result);
    }

    /** @test */
    public function send_reset_link_email_throws_exception_when_user_not_found()
    {
        $email = 'nonexistent@example.com';

        $this->passwordBrokerMock
            ->shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => $email])
            ->andReturn(Password::INVALID_USER);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Pengguna tidak ditemukan.');

        $this->service->sendResetLinkEmail($email);
    }

    /** @test */
    public function send_reset_link_email_throws_exception_on_other_errors()
    {
        $email = 'user@example.com';

        $this->passwordBrokerMock
            ->shouldReceive('sendResetLink')
            ->once()
            ->andReturn(Password::RESET_THROTTLED);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Gagal mengirim link reset password.');

        $this->service->sendResetLinkEmail($email);
    }

    /** @test */
    public function resend_reset_link_sends_link_and_hits_rate_limiter_when_successful()
    {
        $email = 'user@example.com';

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with(Mockery::any(), 5)
            ->andReturn(false);

        $this->passwordBrokerMock
            ->shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => $email])
            ->andReturn(Password::RESET_LINK_SENT);

        RateLimiter::shouldReceive('hit')
            ->once()
            ->with(Mockery::any(), 120);


        $this->service->resendResetLink($email);


        $this->assertTrue(true);
    }

    /** @test */
    public function resend_reset_link_throws_rate_limit_exception_when_too_many_attempts()
    {
        $email = 'spam@example.com';

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->with(Mockery::any(), 5)
            ->andReturn(true);

        RateLimiter::shouldReceive('availableIn')
            ->once()
            ->with(Mockery::any())
            ->andReturn(90);

        $this->expectException(RateLimitExceededException::class);
        $this->expectExceptionMessage('Terlalu banyak permintaan. Coba lagi dalam 90 detik.');

        $this->service->resendResetLink($email);
    }

    /** @test */
    public function resend_reset_link_throws_exception_when_send_fails()
    {
        $email = 'fail@example.com';

        RateLimiter::shouldReceive('tooManyAttempts')
            ->once()
            ->andReturn(false);

        $this->passwordBrokerMock
            ->shouldReceive('sendResetLink')
            ->once()
            ->andReturn(Password::RESET_THROTTLED);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Gagal mengirim ulang tautan reset password.');

        $this->service->resendResetLink($email);
    }

    /** @test */
    public function reset_password_returns_success_and_clears_limiter_when_reset_successful()
    {
        $email = 'user@example.com';
        $token = 'valid-token';
        $password = 'newpassword123';

        Hash::shouldReceive('make')
            ->once()
            ->with($password)
            ->andReturn('hashed-password');

        $userMock = Mockery::mock(\App\Models\User::class);
        $userMock->shouldReceive('setAttribute')
            ->once()
            ->with('password', 'hashed-password');
        $userMock->shouldReceive('save')
            ->once();

        $this->passwordBrokerMock
            ->shouldReceive('reset')
            ->once()
            ->with(
                [
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $password,
                    'token' => $token,
                ],
                Mockery::on(function ($callback) use ($userMock) {

                    $callback($userMock);
                    return true;
                })
            )
            ->andReturn(Password::PASSWORD_RESET);

        RateLimiter::shouldReceive('clear')
            ->once()
            ->with(Mockery::any());

        $result = $this->service->resetPassword($token, $email, $password);

        $this->assertEquals(['status' => 'success'], $result);
    }

    /** @test */
    public function reset_password_throws_exception_when_token_invalid()
    {
        $email = 'user@example.com';
        $token = 'invalid-token';
        $password = 'newpassword123';

        $this->passwordBrokerMock
            ->shouldReceive('reset')
            ->once()
            ->andReturn(Password::INVALID_TOKEN);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Token reset password tidak valid atau telah kedaluwarsa.');

        $this->service->resetPassword($token, $email, $password);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
