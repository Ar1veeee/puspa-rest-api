<?php

namespace App\Http\Services;

use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthService
{
    protected $userRepository;
    protected $guardianRepository;

    public function __construct(
        UserRepository     $userRepository,
        GuardianRepository $guardianRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->guardianRepository = $guardianRepository;
    }

    /**
     * Register new user
     *
     * @param array $data
     * @return string User ID
     * @throws ValidationException
     */
    public function register(array $data): string
    {
        $this->validateRegistration($data);

        DB::beginTransaction();
        try {
            $user = $this->createUser($data);
            $this->linkGuardianToUser($data['email'], $user->id);
            $this->sendVerificationEmail($user);

            DB::commit();

            return $user->id;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Login user and generate token
     *
     * @param array $data
     * @return array Contains user and token
     * @throws AuthenticationException
     */
    public function login(array $data): array
    {
        $user = $this->authenticateUser($data);

        $this->revokeAllUserTokens($user);

        $token = $this->generateUserToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout current user
     *
     * @return void
     */
    public function logout(): void
    {
        $user = request()->user();

        if ($user) {
            request()->user()->currentAccessToken()->delete();
        }
    }

    // ========== Private Helper Methods ==========

    /**
     * Validate all registration requirements
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validateRegistration(array $data): void
    {
        if ($this->userRepository->checkExistingUsername($data['username'])) {
            throw ValidationException::withMessages([
                'username' => ['Username sudah digunakan.'],
            ]);
        }

        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah terdaftar sebagai pengguna.'],
            ]);
        }

        if (!$this->guardianRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email tidak ditemukan. Silakan hubungi admin untuk pendaftaran observasi terlebih dahulu.'],
            ]);
        }

        if (!$this->guardianRepository->hasObservationContinuedToAssessment($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Observasi Anda belum disetujui. Silakan hubungi terapis untuk informasi lebih lanjut.']
            ]);
        }
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return \App\Models\User
     */
    private function createUser(array $data)
    {
        return $this->userRepository->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'is_active' => false,
        ]);
    }

    /**
     * Link guardian to user
     *
     * @param string $email
     * @param string $userId
     * @return void
     */
    private function linkGuardianToUser(string $email, string $userId): void
    {
        $this->guardianRepository->updateUserIdByEmail($email, $userId);
        $this->guardianRepository->removeTempEmail($userId);
    }

    /**
     * Send verification email with error handling
     *
     * @param \App\Models\User $user
     * @return void
     */
    private function sendVerificationEmail($user): void
    {
        $user->sendEmailVerificationNotification();
    }

    /**
     * Authenticate user credentials
     *
     * @param array $data
     * @return \App\Models\User
     * @throws AuthenticationException
     */
    private function authenticateUser(array $data)
    {
        $user = $this->userRepository->getByIdentifier($data['identifier']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Username atau email dan password tidak cocok.');
        }

        if (!$user->is_active) {
            throw new AuthenticationException('Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi.');
        }

        return $user;
    }

    /**
     * Revoke all user tokens
     *
     * @param \App\Models\User $user
     * @return void
     */
    private function revokeAllUserTokens($user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Generate new access token for user
     *
     * @param \App\Models\User $user
     * @return string Plain text token
     */
    private function generateUserToken($user): string
    {
        $tokenName = 'api-token-' . now()->timestamp;
        $expiresAt = now()->addDays(7);

        return $user->createToken($tokenName, ['*'], $expiresAt)->plainTextToken;
    }
}
