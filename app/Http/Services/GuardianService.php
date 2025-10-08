<?php

namespace App\Http\Services;

use App\Http\Repositories\FamilyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Models\Guardian;
use Illuminate\Support\Facades\DB;

class GuardianService
{
    protected $guardianRepository;
    protected $familyRepository;

    public function __construct(GuardianRepository $guardianRepository, FamilyRepository $familyRepository)
    {
        $this->guardianRepository = $guardianRepository;
        $this->familyRepository = $familyRepository;
    }

    public function updateGuardians(array $data, string $userId)
    {
        DB::beginTransaction();
        try {
            $guardian = $this->guardianRepository->findByUserId($userId);
            $familyId = $guardian->family_id;

            $types = [
                'ayah' => [
                    'guardian_name' => $data['father_name'] ?? null,
                    'guardian_phone' => $data['father_phone'] ?? null,
                    'guardian_birth_date' => $data['father_birth_date'] ?? null,
                    'guardian_occupation' => $data['father_occupation'] ?? null,
                    'relationship_with_child' => $data['father_relationship'] ?? null,
                ],
                'ibu' => [
                    'guardian_name' => $data['mother_name'] ?? null,
                    'guardian_phone' => $data['mother_phone'] ?? null,
                    'guardian_birth_date' => $data['mother_birth_date'] ?? null,
                    'guardian_occupation' => $data['mother_occupation'] ?? null,
                    'relationship_with_child' => $data['mother_relationship'] ?? null,
                ],
                'wali' => [
                    'guardian_name' => $data['wali_name'] ?? null,
                    'guardian_phone' => $data['wali_phone'] ?? null,
                    'guardian_birth_date' => $data['wali_birth_date'] ?? null,
                    'guardian_occupation' => $data['wali_occupation'] ?? null,
                    'relationship_with_child' => $data['wali_relationship'] ?? null,
                ],
            ];
            foreach ($types as $type => $info) {
                $info = array_map(fn($v) => is_string($v) ? trim($v) : $v, $info);

                $hasData = array_filter($info, fn($v) => $v !== null && $v !== '');

                if (!$hasData) {
                    continue;
                }

                $existing = $this->guardianRepository->findByFamilyIdAndType($familyId, $type);

                $payload = [
                    'family_id' => $familyId,
                    'user_id' => $userId,
                    'guardian_type' => $type,
                    'guardian_name' => $info['guardian_name'],
                    'guardian_phone' => $info['guardian_phone'],
                    'guardian_birth_date' => $info['guardian_birth_date'],
                    'guardian_occupation' => $info['guardian_occupation'],
                    'relationship_with_child' => $info['relationship_with_child'],
                ];

                if ($existing) {
                    $existing->update($payload);
                } else {
                    $this->guardianRepository->create($payload);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
