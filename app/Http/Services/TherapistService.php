<?php

namespace App\Http\Services;

use App\Http\Repositories\TherapistRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class TherapistService
{
    protected $userRepository;
    protected $therapistRepository;

    public function __construct(UserRepository $userRepository, TherapistRepository $therapistRepository)
    {
        $this->userRepository = $userRepository;
        $this->therapistRepository = $therapistRepository;
    }

    /**
     * Get all therapists
     *
     * @return Collection
     */
    public function getAllTherapist(): Collection
    {
        return $this->therapistRepository->getAll();
    }

    /**
     * Get therapist detail by ID
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Collection|\Illuminate\Database\Eloquent\Builder[]
     * @throws ModelNotFoundException
     */
    public function getTherapistDetail(string $id)
    {
        return $this->therapistRepository->getDetailByIdOrFail($id);
    }

    /**
     * Create new therapist
     *
     * @param array $data
     * @return Therapist
     * @throws ValidationException
     */
    public function createTherapist(array $data): Therapist
    {
        $this->validateUniqueCredentials($data);

        DB::beginTransaction();
        try {
            $user = $this->createUserForTherapist($data);
            $therapist = $this->createTherapistProfile($user->id, $data);

            DB::commit();

            return $therapist->load('user');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update existing therapist
     *
     * @param array $data
     * @param string $id
     * @return Therapist
     * @throws ModelNotFoundException|ValidationException
     */
    public function updateTherapist(array $data, string $id): Therapist
    {
        $therapist = $this->findTherapistOrFail($id);
        $user = $this->findUserOrFail($therapist->user_id);

        $this->validateUpdateCredentials($data, $user);

        DB::beginTransaction();
        try {
            $this->updateUserData($user, $data);
            $this->updateTherapistData($therapist, $data);

            DB::commit();

            return $therapist->fresh()->load('user');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete therapist and associated user
     *
     * @param string $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteTherapist(string $id): bool
    {
        $therapist = $this->findTherapistOrFail($id);
        $userId = $therapist->user_id;

        DB::beginTransaction();
        try {
            $this->therapistRepository->delete($id);

            $this->userRepository->delete($userId);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== Private Helper Methods ==========

    /**
     * Validate unique credentials for new therapist
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validateUniqueCredentials(array $data): void
    {
        if ($this->userRepository->checkExistingUsername($data['username'])) {
            throw ValidationException::withMessages([
                'username' => ['Username sudah digunakan.'],
            ]);
        }

        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah digunakan.'],
            ]);
        }
    }

    /**
     * Validate credentials for therapist update
     *
     * @param array $data
     * @param \App\Models\User $user
     * @return void
     * @throws ValidationException
     */
    private function validateUpdateCredentials(array $data, $user): void
    {
        if (isset($data['username']) && $data['username'] !== $user->username) {
            if ($this->userRepository->isUsernameTakenByAnother($data['username'], $user->id)) {
                throw ValidationException::withMessages([
                    'username' => ['Username sudah digunakan.'],
                ]);
            }
        }

        if (isset($data['email']) && $data['email'] !== $user->email) {
            if ($this->userRepository->isEmailTakenByAnother($data['email'], $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['Email sudah digunakan.'],
                ]);
            }
        }
    }

    /**
     * Create user account for therapist
     *
     * @param array $data
     * @return \App\Models\User
     */
    private function createUserForTherapist(array $data)
    {
        return $this->userRepository->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'terapis',
            'is_active' => false,
        ]);
    }

    /**
     * Create therapist profile
     *
     * @param string $userId
     * @param array $data
     * @return Therapist
     */
    private function createTherapistProfile(string $userId, array $data): Therapist
    {
        return $this->therapistRepository->create([
            'user_id' => $userId,
            'therapist_name' => $data['therapist_name'],
            'therapist_section' => $data['therapist_section'],
            'therapist_phone' => $data['therapist_phone'],
        ]);
    }

    /**
     * Update user data
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return void
     */
    private function updateUserData($user, array $data): void
    {
        $userData = array_filter([
            'username' => $data['username'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
        ], fn($value) => $value !== null);

        if (!empty($userData)) {
            $this->userRepository->update($userData, $user->id);
        }
    }

    /**
     * Update therapist data
     *
     * @param Therapist $therapist
     * @param array $data
     * @return void
     */
    private function updateTherapistData(Therapist $therapist, array $data): void
    {
        $therapistData = array_filter([
            'therapist_name' => $data['therapist_name'] ?? null,
            'therapist_section' => $data['therapist_section'] ?? null,
            'therapist_phone' => $data['therapist_phone'] ?? null,
        ], fn($value) => $value !== null);

        if (!empty($therapistData)) {
            $this->therapistRepository->update($therapistData, $therapist->id);
        }
    }

    /**
     * Find therapist or throw exception
     *
     * @param string $id
     * @return Therapist
     * @throws ModelNotFoundException
     */
    private function findTherapistOrFail(string $id): Therapist
    {
        $therapist = $this->therapistRepository->getById($id);

        if (!$therapist) {
            throw new ModelNotFoundException('Data terapis tidak ditemukan.');
        }

        return $therapist;
    }

    /**
     * Find user or throw exception
     *
     * @param string $id
     * @return \App\Models\User
     * @throws ModelNotFoundException
     */
    private function findUserOrFail(string $id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new ModelNotFoundException('Data user terkait tidak ditemukan.');
        }

        return $user;
    }
}
