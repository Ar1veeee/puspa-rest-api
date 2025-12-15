<?php

namespace App\Actions\Guardian;

use App\Models\Guardian;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateFamilyGuardiansAction
{
    public function execute(Guardian $primaryGuardian, array $data): Collection
    {
        $updatedGuardians = collect();

        DB::transaction(function () use ($primaryGuardian, $data, &$updatedGuardians) {
            $familyId = $primaryGuardian->family_id;
            $types = ['ayah', 'ibu', 'wali'];

            foreach ($types as $type) {
                $mapped = $this->mapGuardianData($type, $data);

                if (empty($mapped)) continue;

                $guardian = Guardian::firstOrNew([
                    'family_id' => $familyId,
                    'guardian_type' => $type,
                ]);

                $guardian->fill($mapped);
                $guardian->user_id = $guardian->is($primaryGuardian) ? $primaryGuardian->user_id : null;

                if ($guardian->isDirty()) {
                    $guardian->save();
                }

                $updatedGuardians->push($guardian->load('user'));
            }
        });

        return $updatedGuardians;
    }

    private function mapGuardianData(string $type, array $data): array
    {
        $mapping = [
            'ayah' => [
                'guardian_identity_number' => $data['father_identity_number'] ?? null,
                'guardian_name'            => $data['father_name'] ?? null,
                'guardian_phone'           => $data['father_phone'] ?? null,
                'guardian_birth_date'      => $data['father_birth_date'] ?? null,
                'guardian_occupation'      => $data['father_occupation'] ?? null,
                'relationship_with_child'  => $data['father_relationship'] ?? null,
            ],
            'ibu' => [
                'guardian_identity_number' => $data['mother_identity_number'] ?? null,
                'guardian_name'            => $data['mother_name'] ?? null,
                'guardian_phone'           => $data['mother_phone'] ?? null,
                'guardian_birth_date'      => $data['mother_birth_date'] ?? null,
                'guardian_occupation'      => $data['mother_occupation'] ?? null,
                'relationship_with_child'  => $data['mother_relationship'] ?? null,
            ],
            'wali' => [
                'guardian_identity_number' => $data['guardian_identity_number'] ?? null,
                'guardian_name'            => $data['guardian_name'] ?? null,
                'guardian_phone'           => $data['guardian_phone'] ?? null,
                'guardian_birth_date'      => $data['guardian_birth_date'] ?? null,
                'guardian_occupation'      => $data['guardian_occupation'] ?? null,
                'relationship_with_child'  => $data['guardian_relationship'] ?? null,
            ],
        ];

        return array_filter($mapping[$type], fn($value) => $value !== null && $value !== '');
    }
}
