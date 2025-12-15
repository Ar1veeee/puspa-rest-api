<?php

namespace App\Http\Services;

use App\Actions\Admin\CreateAdminAction;
use App\Actions\Admin\DeleteAdminAction;
use App\Actions\Admin\UpdateAdminAction;
use App\Actions\Admin\UpdateProfileAdminAction;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function index(): Collection
    {
        return Admin::with('user:id,username,email,is_active')
        ->whereHas('user', fn($q) => $q->where('is_active', true))
        ->latest()
        ->get();
    }

    public function show(Admin $admin): Admin
    {
        return $admin->load('user:id,username,email,is_active');
    }

    public function store(array $data): Admin
    {
        return (new CreateAdminAction)->execute($data);
    }

    public function update(array $data, Admin $admin): Admin
    {
        return (new UpdateAdminAction)->execute($admin, $data);
    }

    public function updateProfile(array $data, Admin $admin): Admin
    {
        return (new UpdateProfileAdminAction)->execute($admin, $data);
    }

    public function destroy(Admin $admin):void
    {
        (new DeleteAdminAction)->execute($admin);
    }

    public function getProfile(string $userId): Admin
    {
        return Admin::with('user')->where('user_id', $userId)->firstOrFail();
    }
}
