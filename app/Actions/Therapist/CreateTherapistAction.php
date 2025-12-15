<?php

namespace App\Actions\Therapist;

use App\Models\Therapist;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateTherapistAction
{
    public function execute(array $data): Therapist 
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'terapis',
                'is_active' => false,
            ]);

            $therapist = Therapist::create([
                'user_id' => $user->id,
                'therapist_name' => $data['therapist_name'],
                'therapist_phone' => $data['therapist_phone'],
            ]);

            return $therapist->load('user');
        });
    }
}
