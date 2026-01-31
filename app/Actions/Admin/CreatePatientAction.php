<?php

namespace App\Actions\Admin;

use App\Events\ObservationUpdated;
use App\Models\Child;
use App\Models\Family;
use App\Models\Guardian;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreatePatientAction
{
    public function execute(array $data): Child
    {
        return DB::transaction(function () use ($data) {
            $familyId = $this->findExistingFamily($data);

            if (!$familyId) {
                $family = Family::create();
                $familyId = $family->id;

                Guardian::create([
                    'family_id' => $familyId,
                    'temp_email' => $data['parent_email'],
                    'guardian_name' => $data['parent_name'],
                    'guardian_phone' => $data['parent_phone'],
                    'guardian_type' => $data['guardian_type'],
                ]);
            }

            $child = Child::create([
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

            Observation::create([
                'child_id' => $child->id,
                'age_category' => Child::calculateAgeAndCategory($data['child_birth_date'])['category'],
                'scheduled_date' => now()->addDay()->nextWeekday(),
                'status' => 'pending',
            ]);

            DB::afterCommit(function () {
                event(new ObservationUpdated());
            });

            return $child->load('family.guardians');
        });
    }

    private function findExistingFamily(array $data): ?string
    {
        // 1. Cek dari User Account
        $existingUser = User::where('email', $data['parent_email'])->first();
        if ($existingUser && $existingUser->guardian) {
            return $existingUser->guardian->family_id;
        }

        // 2. Cek dari Guardian Guest (temp_email atau Phone)
        $existingGuardian = Guardian::where('temp_email', $data['parent_email'])
            ->orWhere('guardian_phone', $data['parent_phone'])
            ->first();

        return $existingGuardian?->family_id;
    }
}
