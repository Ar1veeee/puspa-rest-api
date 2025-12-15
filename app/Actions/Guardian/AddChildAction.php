<?php

namespace App\Actions\Guardian;

use App\Models\Child;
use App\Models\Guardian;
use App\Models\Observation;
use Illuminate\Support\Facades\DB;

class AddChildAction
{
    public function execute(Guardian $guardian, array $data): Child
    {
        return DB::transaction(function () use ($guardian, $data) {
            $child = Child::create(
                array_merge($data, [
                    'family_id' => $guardian->family_id,
                ])
            );

            Observation::create([
                'child_id' => $child->id,
                'scheduled_date' => $this->nextWeekDay(),
                'age_category' => Child::calculateAgeAndCategory($data['child_birth_date'])['category'],
                'status' => 'pending',
            ]);

            return $child;
        });
    }

    private function nextWeekDay()
    {
        $date = now()->addDay();
        while ($date->isWeekend()) $date->addDay();

        return $date;
    }
}
