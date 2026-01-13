<?php

namespace App\Actions\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateAdminAction
{
    public function execute(array $data): Admin
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->forceFill([
                'is_active' => false,
            ])->save();

            $user->assignRole('admin');

            $admin = Admin::create([
                'user_id' => $user->id,
                'admin_name' => $data['admin_name'],
                'admin_phone' => $data['admin_phone'],
            ]);

            return $admin->load('user');
        });
    }
}
