<?php

namespace App\Actions\Registration;

use App\Events\ObservationUpdated;
use App\Models\Family;
use App\Models\Child;
use App\Models\Guardian;
use App\Models\Observation;
use Illuminate\Support\Facades\DB;

class RegisterFamilyAction
{
    public function execute(array $data): Child
    {
        return DB::transaction(function () use ($data) {
            $family = Family::create();

            Guardian::create([
                'family_id' => $family->id,
                'temp_email' => $data['email'],
                'guardian_name' => $data['guardian_name'],
                'guardian_phone' => $data['guardian_phone'],
                'guardian_type' => $data['guardian_type'],
            ]);

            $child = Child::create([
                'family_id' => $family->id,
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

            return $child->load('family.children.observation');
        });
    }
}
