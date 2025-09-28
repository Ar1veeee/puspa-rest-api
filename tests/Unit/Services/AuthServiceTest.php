<?php

namespace Tests\Unit\Services;

use App\Notifications\EmailVerificationNotification;
use App\Http\Repositories\UserRepository;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService(new UserRepository(new User()));
    }

    /**
     * @test
     * Testing user registration success.
     */
    public function registerShouldCreateUserAndReturnIdSuccessfully(): void
    {
        Notification::fake();

        $registerData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $userId = $this->authService->register($registerData);

        $this->assertIsString($userId);
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        Notification::assertSentTo(
            User::find($userId),
            EmailVerificationNotification::class
        );
    }

    /**
     * @test
     * Testing user registration failed with existing username.
     */
    public function registerShouldThrowValidationExceptionForExistingUsername(): void
    {
        $this->expectException(ValidationException::class);

        User::factory()->create(['username' => 'existinguser']);

        $registerData = [
            'username' => 'existinguser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $this->authService->register($registerData);
    }

    /**
     * @test
     * Testing user registration failed with existing email.
     */
    public function registerShouldThrowValidationExceptionForExistingEmail(): void
    {
        $this->expectException(ValidationException::class);

        User::factory()->create(['email' => 'existing@example.com']);

        $registerData = [
            'username' => 'newuser',
            'email' => 'existing@example.com',
            'password' => 'password123',
        ];

        $this->authService->register($registerData);
    }

    /**
     * @test
     * Testing user login success with correct credentials.
     */
    public function loginShouldReturnAuthDataWithCorrectCredentials(): void
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $loginData = [
            'identifier' => 'testuser',
            'password' => 'password123',
        ];

        $result = $this->authService->login($loginData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertEquals('testuser', $result['username']);
    }

    /**
     * @test
     * Testing user login failed with incorrect credentials.
     */
    public function loginShouldThrowAuthenticationExceptionForWrongPassword(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Username atau password salah.');

        User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('passwordBenar'),
            'is_active' => true,
        ]);

        $loginData = [
            'identifier' => 'testuser',
            'password' => 'passwordSalah',
        ];

        // ACT
        $this->authService->login($loginData);
    }

    /**
     * @test
     * Testing user login failed with unverified email.
     */
    public function loginShouldThrowAuthenticationExceptionForInactiveUser(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Akun belum aktif, silahkan lakukan verifikasi email !');

        User::factory()->create([
            'username' => 'inactiveuser',
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);

        $loginData = [
            'identifier' => 'inactiveuser',
            'password' => 'password123',
        ];

        $this->authService->login($loginData);
    }
}
