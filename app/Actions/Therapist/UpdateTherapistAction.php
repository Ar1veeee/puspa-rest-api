<?php

namespace App\Actions\Therapist;

use App\Models\Therapist;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateTherapistAction
{
    public function execute(Therapist $therapist, array $data): Therapist
    {
        return DB::transaction(function () use ($therapist, $data) {
            $user = $therapist->user;
            
            $user->update(Arr::only($data, [
                'username',
                'email'
            ]));

            $therapist->update(Arr::only($data, [
                'therapist_name',
                'therapist_phone',
                'therapist_section',
            ]));

            return $therapist->fresh()->load('user');
        });
    }
}
