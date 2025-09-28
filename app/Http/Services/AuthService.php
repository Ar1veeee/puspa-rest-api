<?php

namespace App\Http\Services;

use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;
    protected $guardianRepository;

    public function __construct(
        UserRepository $userRepository,
        GuardianRepository $guardianRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->guardianRepository = $guardianRepository;
    }

    public function register(array $data): string
    {
        if ($this->userRepository->checkExistingUsername($data['username'])) {
            throw ValidationException::withMessages([
                'nama_pengguna' => ['Nama pengguna sudah digunakan'],
            ]);
        }

        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah digunakan'],
            ]);
        }

        if (!$this->guardianRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email belum terdaftar. Silakan melakukan pendaftaran!'],
            ]);
        }

        return DB::transaction(function () use ($data) {
            $userData = [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'user',
            ];

            $user = $this->userRepository->create($userData);
            $userId = $user->id;

            $this->guardianRepository->updateUserIdByEmail($data['email'], $userId);
            $this->guardianRepository->removeTempEmail($userId);

            $user->markEmailAsVerified();

            $user->sendEmailVerificationNotification();

            return $user->id;
        });
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->getByIdentifier($data['identifier']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Username atau password salah. Coba lagi!');
        }

        if (! $user->is_active) {
            throw new AuthenticationException('Akun belum aktif. Silahkan melakukan verifikasi!');
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token', ['*'], now()->addDays(7))->plainTextToken;

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'token_type' => 'Bearer',
            'access_token' => $token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    public function logout(): void
    {
        $user = request()->user();

        if ($user) {
            $user->tokens()->delete();
        }
    }
}
