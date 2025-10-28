<?php

namespace App\Http\Services;

use App\Http\Repositories\ChildRepository;
use App\Http\Repositories\GuardianRepository;
use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ChildService
{
    protected $childRepository;
    protected $guardianRepository;

    public function __construct(
        ChildRepository    $childRepository,
        GuardianRepository $guardianRepository
    )
    {
        $this->childRepository = $childRepository;
        $this->guardianRepository = $guardianRepository;
    }

    public function getAllChild(): Collection
    {
        return $this->childRepository->getAll();
    }

    public function update(array $data, Child $child)
    {
        DB::beginTransaction();
        try {
            $this->updateChild($data, $child);
            $this->updateGuardian($data, $child->family_id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function updateChild(array $data, Child $child)
    {
        $childData = [
            'child_name' => $data['child_name'] ?? null,
            'child_gender' => $data['child_gender'] ?? null,
            'child_birth_place' => $data['child_birth_place'] ?? null,
            'child_birth_date' => $data['child_birth_date'] ?? null,
            'child_school' => $data['child_school'] ?? null,
            'child_address' => $data['child_address'] ?? null,
            'child_complaint' => $data['child_complaint'] ?? null,
            'child_service_choice' => $data['child_service_choice'] ?? null,
        ];

        $childData = array_filter($childData, fn($v) => $v !== null);

        $child->update($childData);
    }

    private function updateGuardian(array $data, string $family_id)
    {
        $types = [
            'Ayah' => [
                'guardian_identity_number' => $data['father_identity_number'] ?? null,
                'guardian_name' => $data['father_name'] ?? null,
                'guardian_phone' => $data['father_phone'] ?? null,
                'guardian_birth_date' => $data['father_birth_date'] ?? null,
                'guardian_occupation' => $data['father_occupation'] ?? null,
                'relationship_with_child' => $data['father_relationship'] ?? null,
            ],
            'Ibu' => [
                'guardian_identity_number' => $data['mother_identity_number'] ?? null,
                'guardian_name' => $data['mother_name'] ?? null,
                'guardian_phone' => $data['mother_phone'] ?? null,
                'guardian_birth_date' => $data['mother_birth_date'] ?? null,
                'guardian_occupation' => $data['mother_occupation'] ?? null,
                'relationship_with_child' => $data['mother_relationship'] ?? null,
            ],
            'Wali' => [
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

            $guardian = $this->guardianRepository->findByFamilyIdAndType($family_id, $type);
            if ($guardian) {
                $guardian->update($info);
            } else {
                $this->guardianRepository->create(
                    array_merge($info, [
                        'family_id' => $family_id,
                        'guardian_type' => $type,
                    ])
                );
            }
        }
    }
}
