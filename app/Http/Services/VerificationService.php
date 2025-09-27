<?php

namespace App\Http\Services;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class VerificationService
{
    use ResponseFormatter;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyEmail(string $userId)
    {
        $user = $this->userRepository->getById($userId);

        if (! $user) {
            throw new ModelNotFoundException('Data user tidak ditemukan');
        }

        if (! URL::hasValidSignature(request())) {
            throw new BadRequestException('Tautan verifikasi tidak valid atau kadaluwarsa. Silakan minta tautan baru.');
        }

        $user->markEmailAsVerified();
    }

    public function resendVerificationNotification(string $userId): array
    {
        $user = $this->userRepository->getById($userId);

        if (! $user) {
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
