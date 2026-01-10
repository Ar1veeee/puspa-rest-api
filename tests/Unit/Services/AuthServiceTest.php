<?php

namespace Tests\Unit\Services;

use App\Actions\Auth\ChangePasswordAction;
use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Models\User;
use App\Services\AuthService;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    private RegisterUserAction|MockInterface $registerAction;
    private LoginUserAction|MockInterface $loginAction;
    private ChangePasswordAction|MockInterface $changePasswordAction;
    private LogoutUserAction|MockInterface $logoutAction;
    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerAction = Mockery::mock(RegisterUserAction::class);
        $this->loginAction = Mockery::mock(LoginUserAction::class);
        $this->changePasswordAction = Mockery::mock(ChangePasswordAction::class);
        $this->logoutAction = Mockery::mock(LogoutUserAction::class);

        $this->authService = new AuthService(
            $this->registerAction,
            $this->loginAction,
            $this->changePasswordAction,
            $this->logoutAction
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_delegates_registration_to_register_action()
    {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $expectedUser = Mockery::mock(User::class);

        $this->registerAction
            ->shouldReceive('execute')
            ->once()
            ->with($userData)
            ->andReturn($expectedUser);

        // Act
        $result = $this->authService->register($userData);

        // Assert
        $this->assertSame($expectedUser, $result);
    }

    /** @test */
    public function it_delegates_login_to_login_action()
    {
        // Arrange
        $credentials = [
            'identifier' => 'testuser',
            'password' => 'password123',
        ];

        $expectedResponse = [
            'user' => Mockery::mock(User::class),
            'token' => 'sample-token-string',
        ];

        $this->loginAction
            ->shouldReceive('execute')
            ->once()
            ->with($credentials)
            ->andReturn($expectedResponse);

        // Act
        $result = $this->authService->login($credentials);

        // Assert
        $this->assertSame($expectedResponse, $result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('token', $result);
    }

    /** @test */
    public function it_delegates_change_password_to_action()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $currentPassword = 'oldpassword';
        $newPassword = 'newpassword123';
        $mockToken = Mockery::mock(PersonalAccessToken::class);

        $user->shouldReceive('currentAccessToken')
            ->once()
            ->andReturn($mockToken);

        $this->changePasswordAction
            ->shouldReceive('execute')
            ->once()
            ->with($user, $currentPassword, $newPassword, $mockToken)
            ->andReturnNull();

        // Act
        $this->authService->changePassword($user, $currentPassword, $newPassword);

        // Assert - Mockery verifies the expectations
        $this->assertTrue(true);
    }

    /** @test */
    public function it_handles_change_password_with_null_token()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $currentPassword = 'oldpassword';
        $newPassword = 'newpassword123';

        $user->shouldReceive('currentAccessToken')
            ->once()
            ->andReturn(null);

        $this->changePasswordAction
            ->shouldReceive('execute')
            ->once()
            ->with($user, $currentPassword, $newPassword, null)
            ->andReturnNull();

        // Act
        $this->authService->changePassword($user, $currentPassword, $newPassword);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_delegates_logout_to_logout_action()
    {
        // Arrange
        $this->logoutAction
            ->shouldReceive('execute')
            ->once()
            ->withNoArgs()
            ->andReturnNull();

        // Act
        $this->authService->logout();

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function register_returns_user_instance()
    {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $user = Mockery::mock(User::class);

        $this->registerAction
            ->shouldReceive('execute')
            ->once()
            ->with($userData)
            ->andReturn($user);

        // Act
        $result = $this->authService->register($userData);

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    /** @test */
    public function login_returns_array_with_user_and_token_keys()
    {
        // Arrange
        $credentials = [
            'identifier' => 'testuser',
            'password' => 'password123',
        ];

        $mockUser = Mockery::mock(User::class);
        $response = [
            'user' => $mockUser,
            'token' => 'abc123token',
        ];

        $this->loginAction
            ->shouldReceive('execute')
            ->once()
            ->with($credentials)
            ->andReturn($response);

        // Act
        $result = $this->authService->login($credentials);

        // Assert
        $this->assertIsArray($result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('token', $result);
        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertIsString($result['token']);
    }

    /** @test */
    public function change_password_passes_correct_parameters_to_action()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $currentPassword = 'oldpass';
        $newPassword = 'newpass';
        $token = Mockery::mock(PersonalAccessToken::class);

        $user->shouldReceive('currentAccessToken')
            ->once()
            ->andReturn($token);

        $this->changePasswordAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($u, $cp, $np, $t) use ($user, $currentPassword, $newPassword, $token) {
                return $u === $user &&
                    $cp === $currentPassword &&
                    $np === $newPassword &&
                    $t === $token;
            })
            ->andReturnNull();

        // Act
        $this->authService->changePassword($user, $currentPassword, $newPassword);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function logout_invokes_logout_action()
    {
        // Arrange
        $this->logoutAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->authService->logout();

        // Assert
        $this->expectNotToPerformAssertions();
    }
}
