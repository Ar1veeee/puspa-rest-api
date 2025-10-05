<?php

namespace App\Http\Services;

use App\Http\Repositories\ChildRepository;
use App\Http\Repositories\FamilyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Child;
use App\Traits\ClearsCaches;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class RegistrationService
{
    use ClearsCaches;

    private $userRepository;
    protected $familyRepository;
    protected $guardianRepository;
    protected $childRepository;
    protected $observationRepository;

    private const DEFAULT_OBSERVATION_DAYS_AHEAD = 1;

    public function __construct(
        UserRepository        $userRepository,
        FamilyRepository      $familyRepository,
        GuardianRepository    $guardianRepository,
        ChildRepository       $childRepository,
        ObservationRepository $observationRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->familyRepository = $familyRepository;
        $this->guardianRepository = $guardianRepository;
        $this->childRepository = $childRepository;
        $this->observationRepository = $observationRepository;
    }

    /**
     * Register new family with child and schedule observation
     *
     * @param array $data
     * @return array Contains registration details
     * @throws ValidationException
     */
    public function registration(array $data)
    {
        $this->validateRegistration($data);

        DB::beginTransaction();
        try {
            $family = $this->createFamily();
            $this->createGuardian($family->id, $data);
            $child = $this->createChild($family->id, $data);
            $this->createObservation($child, $data['child_birth_date']);

            DB::commit();

            return $this->clearObservationCaches();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== Private Helper Methods ==========

    /**
     * Validate registration data
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validateRegistration(array $data): void
    {
        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah terdaftar sebagai pengguna. Silakan gunakan email lain atau login.'],
            ]);
        }

        if ($this->guardianRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah terdaftar untuk pendaftaran observasi. Silakan cek email Anda atau hubungi admin.'],
            ]);
        }

        $this->validateChildAge($data['child_birth_date']);
    }

    /**
     * Validate child age for observation eligibility
     *
     * @param string $birthDate
     * @return void
     * @throws ValidationException
     */
    private function validateChildAge(string $birthDate): void
    {
        $ageInfo = Child::calculateAgeAndCategory($birthDate);

        if (empty($ageInfo['category'])) {
            throw ValidationException::withMessages([
                'child_birth_date' => ['Tidak dapat menentukan kategori usia untuk observasi.'],
            ]);
        }
    }

    /**
     * Create family record
     *
     * @return \App\Models\Family
     */
    private function createFamily()
    {
        return $this->familyRepository->create([]);
    }

    /**
     * Create guardian record
     *
     * @param string $familyId
     * @param array $data
     * @return \App\Models\Guardian
     */
    private function createGuardian(string $familyId, array $data)
    {
        return $this->guardianRepository->create([
            'family_id' => $familyId,
            'temp_email' => $data['email'],
            'guardian_name' => $data['guardian_name'],
            'guardian_phone' => $data['guardian_phone'],
            'guardian_type' => $data['guardian_type'],
        ]);
    }

    /**
     * Create child record
     *
     * @param string $familyId
     * @param array $data
     * @return Child
     */
    private function createChild(string $familyId, array $data): Child
    {
        return $this->childRepository->create([
            'family_id' => $familyId,
            'child_name' => $data['child_name'],
            'child_gender' => $data['child_gender'],
            'child_birth_place' => $data['child_birth_place'],
            'child_birth_date' => $data['child_birth_date'],
            'child_school' => $data['child_school'] ?? null,
            'child_address' => $data['child_address'],
            'child_complaint' => $data['child_complaint'],
            'child_service_choice' => $data['child_service_choice'],
        ]);
    }

    /**
     * Create observation record
     *
     * @param Child $child
     * @param string $birthDate
     * @return \App\Models\Observation
     */
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

    /**
     * Calculate scheduled date for observation
     *
     * @return \Carbon\Carbon
     */
    private function calculateScheduledDate()
    {
        $date = now()->addDays(self::DEFAULT_OBSERVATION_DAYS_AHEAD);

        while ($date->isWeekend()) {
            $date->addDay();
        }

        return $date;
    }
}
