<?php

namespace App\Http\Services;

use App\Http\Repositories\ChildRepository;
use App\Http\Repositories\FamilyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GuardianService
{
    protected $userRepository;
    protected $guardianRepository;
    protected $familyRepository;
    protected $childRepository;
    protected $observationRepository;

    private const DEFAULT_OBSERVATION_DAYS_AHEAD = 1;

    public function __construct(
        UserRepository        $userRepository,
        GuardianRepository    $guardianRepository,
        FamilyRepository      $familyRepository,
        ChildRepository       $childRepository,
        ObservationRepository $observationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->guardianRepository = $guardianRepository;
        $this->familyRepository = $familyRepository;
        $this->childRepository = $childRepository;
        $this->observationRepository = $observationRepository;
    }

    public function getProfile(string $user_id)
    {
        return $this->guardianRepository->findByUserId($user_id);
    }

    public function getChildren(string $user_id)
    {
        $guardian = $this->guardianRepository->findByUserId($user_id);
        if (!$guardian) {
            throw new ModelNotFoundException('Data Orang Tua Tidak Ditemukan');
        }

        return $this->guardianRepository->getChildrenByUserId($guardian->user_id);
    }

    public function addChild(string $user_id, array $data)
    {
        $guardian = $this->guardianRepository->findByUserId($user_id);
        if (!$guardian) {
            throw new ModelNotFoundException('Data Orang Tua Tidak Ditemukan');
        }

        return DB::transaction(function () use ($guardian, $data) {
            $child = $this->childRepository->create(
                array_merge($data, [
                    'family_id' => $guardian->family_id,
                ])
            );
            $this->createObservation($child, $data['child_birth_date']);
        });
    }

    public function updateGuardians(array $data, string $user_id)
    {
        DB::beginTransaction();
        try {
            $primaryGuardian = $this->guardianRepository->findByUserId($user_id);
            if (!$primaryGuardian) {
                throw new \Exception('Data wali utama tidak ditemukan.');
            }

            $family_id = $primaryGuardian->family_id;

            $types = [
                'ayah' => [
                    'guardian_identity_number' => $data['father_identity_number'] ?? null,
                    'guardian_name' => $data['father_name'] ?? null,
                    'guardian_phone' => $data['father_phone'] ?? null,
                    'guardian_birth_date' => $data['father_birth_date'] ?? null,
                    'guardian_occupation' => $data['father_occupation'] ?? null,
                    'relationship_with_child' => $data['father_relationship'] ?? null,
                ],
                'ibu' => [
                    'guardian_identity_number' => $data['mother_identity_number'] ?? null,
                    'guardian_name' => $data['mother_name'] ?? null,
                    'guardian_phone' => $data['mother_phone'] ?? null,
                    'guardian_birth_date' => $data['mother_birth_date'] ?? null,
                    'guardian_occupation' => $data['mother_occupation'] ?? null,
                    'relationship_with_child' => $data['mother_relationship'] ?? null,
                ],
                'wali' => [
                    'guardian_identity_number' => $data['guardian_identity_number'] ?? null,
                    'guardian_name' => $data['guardian_name'] ?? null,
                    'guardian_phone' => $data['guardian_phone'] ?? null,
                    'guardian_birth_date' => $data['guardian_birth_date'] ?? null,
                    'guardian_occupation' => $data['guardian_occupation'] ?? null,
                    'relationship_with_child' => $data['guardian_relationship'] ?? null,
                ],
            ];

            foreach ($types as $type => $info) {
                $info = array_map(fn($v) => is_string($v) ? trim($v) : $v, $info);

                $hasData = collect($info)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();

                if (!$hasData) {
                    continue;
                }

                $existingGuardian = $this->guardianRepository->findByFamilyIdAndType($family_id, $type);

                if ($existingGuardian) {
                    $existingGuardian->update($info);
                } else {
                    $payload = array_merge($info, [
                        'family_id' => $family_id,
                        'guardian_type' => $type,
                        'user_id' => ($primaryGuardian->guardian_type === $type) ? $user_id : null,
                    ]);
                    $this->guardianRepository->create($payload);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProfile(array $data, Guardian $guardian)
    {
        $user = $this->findUserOrFail($guardian->user_id);

        if (isset($data['email']) && $data['email'] !== $user->email) {
            if ($this->userRepository->isEmailTakenByAnother($data['email'], $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['Email sudah digunakan.'],
                ]);
            }
        }

        DB::beginTransaction();
        try {
            $this->updateUserData($user, $data);
            $this->updateGuardianData($guardian, $data);

            DB::commit();

            return $guardian->fresh()->load('user');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updatePassword(array $data, string $userId)
    {
        $this->findUserOrFail($userId);
        $hashedPassword = Hash::make($data['password']);
        return $this->userRepository->update(['password' => $hashedPassword], $userId);
    }

    private function findUserOrFail(string $id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new ModelNotFoundException('Pengguna tidak ditemukan.');
        }

        return $user;
    }

    private function createObservation(Child $child, string $birthDate)
    {
        $ageInfo = Child::calculateAgeAndCategory($birthDate);

        return $this->observationRepository->create([
            'child_id' => $child->id,
            'scheduled_date' => $this->calculateScheduledDate(),
            'age_category' => $ageInfo['category'],
            'status' => 'pending',
        ]);
    }

    private function updateUserData($user, array $data): void
    {
        $userData = array_filter([
            'email' => $data['email'] ?? null,
        ], fn($value) => $value !== null);

        if (!empty($userData)) {
            $this->userRepository->update($userData, $user->id);
        }
    }

    private function updateGuardianData(Guardian $guardian, array $data): void
    {
        $guardianData = Arr::whereNotNull([
            'guardian_name' => $data['guardian_name'] ?? null,
            'relationship_with_child' => $data['relationship_with_child'] ?? null,
            'guardian_birth_date' => $data['guardian_birth_date'] ?? null,
            'guardian_phone' => $data['guardian_phone'] ?? null,
            'guardian_occupation' => $data['guardian_occupation'] ?? null,
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);

        if (!empty($guardianData)) {
            $this->guardianRepository->update($guardianData, $guardian->id);
        }
    }

    private function calculateScheduledDate()
    {
        $date = now()->addDays(self::DEFAULT_OBSERVATION_DAYS_AHEAD);

        while ($date->isWeekend()) {
            $date->addDay();
        }

        return $date;
    }
}
