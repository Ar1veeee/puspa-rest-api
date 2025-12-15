<?php

namespace App\Actions\Therapist;

use App\Models\Therapist;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateProfileTherapistAction
{
    public function execute(Therapist $therapist, array $data): Therapist
    {
        return DB::transaction(function () use ($therapist, $data) {
            $user = $therapist->user;
            
            $user->update(Arr::only($data, [
                'email'
            ]));

            $therapist->update(Arr::only($data, [
                'therapist_name',
                'therapist_phone',
                'therapist_birth_date',
                'profile_picture',
            ]));

            return $therapist->fresh()->load('user');
        });
    }
}
