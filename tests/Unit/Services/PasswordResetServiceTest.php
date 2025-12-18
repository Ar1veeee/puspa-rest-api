<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use App\Services\ResetPasswordService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ResetPasswordService $passwordResetService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passwordResetService = new ResetPasswordService(new UserRepository(new User()));
        $this->user = User::factory()->create(['email' => 'test@example.com']);
    }

    /**
     * @test
     * Testing reset link email success if email found.
     */
    public function sendResetLinkEmailShouldSucceedWhenEmailExists(): void
    {
        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => 'test@example.com'])
            ->andReturn(Password::RESET_LINK_SENT);

        $result = $this->passwordResetService->sendResetLinkEmail('test@example.com');

        $this->assertTrue($result['success']);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Tautan reset password telah dikirim ke email Anda.', $result['message']);
    }

    /**
     * @test
     * Testing reset link email failed when email not found.
     */
    public function sendResetLinkEmailShouldThrowExceptionWhenEmailNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Pengguna tidak ditemukan');

        $this->passwordResetService->sendResetLinkEmail('notfound@example.com');
    }

    /**
     * @test
     * Testing reset password success with valid token.
     */
    public function resetPasswordShouldSucceedWithValidToken(): void
    {
        $token = Password::createToken($this->user);
        $newPassword = 'newStrongPassword123';

        $result = $this->passwordResetService->resetPassword(
            $token,
            $this->user->email,
            $newPassword
        );

        $this->assertTrue($result['success']);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Password berhasil diatur ulang. Silakan login.', $result['message']);

        $this->user->refresh();
        $this->assertTrue(Hash::check($newPassword, $this->user->password));
    }

    /**
     * @test
     * Testing reset password failed with invalid token.
     */
    public function resetPasswordShouldFailWithInvalidToken(): void
    {
        $invalidToken = 'this-is-an-invalid-token';
        $newPassword = 'newStrongPassword123';

        $result = $this->passwordResetService->resetPassword(
            $invalidToken,
            $this->user->email,
            $newPassword
        );

        $this->assertFalse($result['success']);
        $this->assertEquals(400, $result['status']);
        $this->assertEquals('Token reset password tidak valid atau telah kedaluwarsa.', $result['message']);

        $oldPassword = $this->user->password;
        $this->user->refresh();
        $this->assertEquals($oldPassword, $this->user->password);
    }
}
