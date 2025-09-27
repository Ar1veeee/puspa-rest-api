<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): string
    {
        if ($this->userRepository->checkExistingUsername($data['username'])) {
            throw ValidationException::withMessages([
                'error' => ['Username sudah digunakan'],
            ]);
        }

        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'error' => ['Email sudah digunakan'],
            ]);
        }

        $userData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ];

        $user = $this->userRepository->create($userData);
        $user->sendEmailVerificationNotification();

        return $user->id;
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->getByIdentifier($data['identifier']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Username atau password salah.');
        }

        if (! $user->is_active) {
            throw new AuthenticationException('Akun belum aktif, silahkan lakukan verifikasi email !');
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
