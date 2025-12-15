<?php

namespace App\Actions\Admin;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateProfileAdminAction
{
    public function execute(Admin $admin, array $data): Admin
    {
        return DB::transaction(function () use ($admin, $data) {
            $user = $admin->user;
            
            $user->update(Arr::only($data, [
                'email'
            ]));

            $admin->update(Arr::only($data, [
                'admin_name',
                'admin_phone',
                'admin_birth_date',
                'profile_picture',
            ]));

            return $admin->fresh()->load('user');
        });
    }
}
