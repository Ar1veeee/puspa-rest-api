<?php

namespace App\Http\Services;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerificationService
{
    use ResponseFormatter;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateHash(string $userId, string $hash): void
    {
        $user = $this->userRepository->getById($userId);

        if (!$user) {
            throw new ModelNotFoundException('User tidak ditemukan');
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string)$hash)) {
            throw new AuthorizationException('Tautan verifikasi tidak valid');
        }
    }

    public function verifyEmail(string $userId)
    {
        $user = $this->userRepository->getById($userId);

        if (!$user) {
            throw new ModelNotFoundException('User tidak ditemukan');
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'status' => 200,
                'message' => 'Email sudah terverifikasi.',
                'data' => [],
            ];
        }

        $user->markEmailAsVerified();
    }

    public function resendVerificationNotification(string $userId): array
    {
        $user = $this->userRepository->getById($userId);

        if (!$user) {
            throw new ModelNotFoundException('Data user tidak ditemukan');
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'status' => 200,
                'message' => 'Email sudah terverifikasi.',
                'data' => [],
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'status' => 202,
            'message' => 'Link verifikasi baru telah dikirim!',
            'data' => [],
        ];
    }
}
