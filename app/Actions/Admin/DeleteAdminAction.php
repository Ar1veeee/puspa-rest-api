<?php

namespace App\Actions\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class DeleteAdminAction
{
    public function execute(Admin $admin): void
    {
        DB::transaction(function () use ($admin) {
            $admin->user()->delete();
            $admin->delete();
        });
    }
}