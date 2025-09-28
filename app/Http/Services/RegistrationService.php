<?php

namespace App\Http\Services;

use App\Http\Repositories\ChildRepository;
use App\Http\Repositories\FamilyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Child;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    private $userRepository;
    protected $familyRepository;
    protected $guardianRepository;
    protected $childRepository;
    protected $observationRepository;

    public function __construct(
        UserRepository $userRepository,
        FamilyRepository $familyRepository,
        GuardianRepository $guardianRepository,
        ChildRepository $childRepository,
        ObservationRepository $observationRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->familyRepository = $familyRepository;
        $this->guardianRepository = $guardianRepository;
        $this->childRepository = $childRepository;
        $this->observationRepository = $observationRepository;
    }

    public function registration(array $data)
    {
        $existingEmail = $this->userRepository->checkExistingEmail($data['email']);
        if ($existingEmail) {
            throw ValidationException::withMessages([
                'error' => ['Eamil sudah digunakan'],
            ]);
        }

        DB::transaction(function () use ($data) {
            $newFamily = $this->familyRepository->create([]);
            $familyId = $newFamily->id;

            $guardianData = [
                'family_id' => $familyId,
                'temp_email' => $data['email'],
                'guardian_name' => $data['guardian_name'],
                'guardian_phone' => $data['guardian_phone'],
                'guardian_type' => $data['guardian_type'],
            ];

            $this->guardianRepository->create($guardianData);

            $ageInfo = Child::calculateAgeAndCategory($data['child_birth_date']);

            $childData = [
                'family_id' => $familyId,
                'child_name' => $data['child_name'],
                'child_gender' => $data['child_gender'],
                'child_birth_place' => $data['child_birth_place'],
                'child_birth_date' => $data['child_birth_date'],
                'child_school' => $data['child_school'],
                'child_address' => $data['child_address'],
                'child_complaint' => $data['child_complaint'],
                'child_service_choice' => $data['child_service_choice'],
            ];

            $newChild = $this->childRepository->create($childData);
            $childId = $newChild->id;

            $observationData = [
                'child_id' => $childId,
                'scheduled_date' => now()->addDay(),
                'age_category' => $ageInfo['category'],
                'status' => 'pending',
            ];

            $this->observationRepository->create($observationData);
        });
    }
}
