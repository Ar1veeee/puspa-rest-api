<?php

namespace App\Actions\Admin;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateAdminAction
{
    public function execute(Admin $admin, array $data): Admin
    {
        return DB::transaction(function () use ($admin, $data) {
            $user = $admin->user;
            
            $user->update(Arr::only($data, [
                'username',
                'email'
            ]));

            $admin->update(Arr::only($data, [
                'admin_name',
                'admin_phone',
            ]));

            return $admin->fresh()->load('user');
        });
    }
}
