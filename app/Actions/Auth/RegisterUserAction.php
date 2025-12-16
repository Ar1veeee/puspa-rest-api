<?php

namespace App\Actions\Auth;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegisterUserAction
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'is_active' => false,
            ]);

            $user->assignRole('user');

            Guardian::where('temp_email', $data['email'])
                ->update(['user_id' => $user->id, 'temp_email' => null]);

            event(new Registered($user));

            return $user;
        });
    }
}
