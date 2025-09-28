<?php

namespace App\Http\Services;

use App\Http\Repositories\TherapistRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TherapistService
{
    protected $userRepository;

    protected $therapistRepository;

    public function __construct(UserRepository $userRepository, TherapistRepository $therapistRepository)
    {
        $this->userRepository = $userRepository;
        $this->therapistRepository = $therapistRepository;
    }

    public function getAllTherapist()
    {
        $therapists = $this->therapistRepository->getAll();
        $therapistsData = [];

        foreach ($therapists as $therapist) {
            $therapistsData[] = [
                'id' => $therapist->id,
                'user_id' => $therapist->user_id,
                'email' => $therapist->user->email,
                'username' => $therapist->user->username,
                'therapist_name' => $therapist->therapist_name,
                'therapist_section' => $therapist->therapist_section,
                'therapist_phone' => $therapist->therapist_phone,
                'created_at' => $therapist->created_at,
                'updated_at' => $therapist->updated_at,
            ];
        }

        return $therapistsData;
    }

    public function getTherapistDetail(string $id)
    {
        $therapist = $this->therapistRepository->getDetailById($id);

        if (! $therapist) {
            throw new ModelNotFoundException('Data terapis tidak ditemukan.');
        }

        return [
            'id' => $therapist->id,
            'user_id' => $therapist->user_id,
            'email' => $therapist->user->email,
            'username' => $therapist->user->username,
            'therapist_name' => $therapist->therapist_name,
            'therapist_section' => $therapist->therapist_section,
            'therapist_phone' => $therapist->therapist_phone,
            'created_at' => $therapist->created_at,
            'updated_at' => $therapist->updated_at,
        ];
    }

    public function createTherapist(array $data): void
    {
        $existingUsername = $this->userRepository->checkExistingUsername($data['username']);
        if ($existingUsername) {
            throw ValidationException::withMessages([
                'error' => ['Username sudah digunakan'],
            ]);
        }

        $existingEmail = $this->userRepository->checkExistingEmail($data['email']);
        if ($existingEmail) {
            throw ValidationException::withMessages([
                'error' => ['Eamil sudah digunakan'],
            ]);
        }

        DB::transaction(function () use ($data) {
            $userData = [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'terapis',
            ];

            $newUser = $this->userRepository->create($userData);

            $userId = $newUser->id;

            $therapistData = [
                'user_id' => $userId,
                'therapist_name' => $data['therapist_name'],
                'therapist_section' => $data['therapist_section'],
                'therapist_phone' => $data['therapist_phone'],
            ];

            $this->therapistRepository->create($therapistData);
        });
    }

    public function updateTherapist(array $data, string $id)
    {
        $therapist = $this->therapistRepository->getById($id);
        if (! $therapist) {
            throw new ModelNotFoundException('Data terapis tidak ditemukan.');
        }

        $user = $this->userRepository->getById($therapist->user_id);
        if (! $user) {
            throw new ModelNotFoundException('Data user terkait tidak ditemukan.');
        }

        if (isset($data['username']) && $data['username'] !== $user->username) {
            if ($this->userRepository->isUsernameTakenByAnother($data['username'], $user->id)) {
                throw ValidationException::withMessages([
                    'nama_pengguna' => ['Nama pengguna sudah digunakan'],
                ]);
            }
        }

        if (isset($data['email']) && $data['email'] !== $user->email) {
            if ($this->userRepository->isEmailTakenByAnother($data['username'], $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['Email sudah digunakan'],
                ]);
            }
        }

        $userData = [];
        if (isset($data['username'])) {
            $userData['username'] = $data['username'];
        }
        if (isset($data['email'])) {
            $userData['email'] = $data['email'];
        }
        if (isset($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }
        if (! empty($userData)) {
            $this->userRepository->update($userData, $user->id);
        }

        $therapistData = [];
        if (isset($data['therapist_name'])) {
            $therapistData['therapist_name'] = $data['therapist_name'];
        }
        if (isset($data['therapist_section'])) {
            $therapistData['therapist_section'] = $data['therapist_section'];
        }
        if (isset($data['therapist_phone'])) {
            $therapistData['therapist_phone'] = $data['therapist_phone'];
        }
        if (! empty($therapistData)) {
            $this->therapistRepository->update($therapistData, $id);
        }
    }

    public function deleteTherapist(string $id)
    {
        return $this->therapistRepository->delete($id);
    }
}
