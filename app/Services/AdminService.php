<?php

namespace App\Services;

use App\Actions\Admin\CreateAdminAction;
use App\Actions\Admin\DeleteAdminAction;
use App\Actions\Admin\UpdateAdminAction;
use App\Actions\Admin\UpdateProfileAdminAction;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function __construct(
        private CreateAdminAction $createAdminAction,
        private UpdateAdminAction $updateAdminAction,
        private UpdateProfileAdminAction $updateProfileAdminAction,
        private DeleteAdminAction $deleteAdminAction,
    ) {}

    public function index(): Collection
    {
        return Admin::with('user:id,username,email,is_active')
            ->whereHas('user', fn($q) => $q->where('is_active', true)) // dihapus kalau ga error
            ->latest()
            ->get();
    }

    public function show(Admin $admin): Admin
    {
        return $admin->load('user:id,username,email,is_active');
    }

    public function store(array $data): Admin
    {
        return $this->createAdminAction->execute($data);
    }

    public function update(array $data, Admin $admin): Admin
    {
        return $this->updateAdminAction->execute($admin, $data);
    }

    public function updateProfile(array $data, Admin $admin): Admin
    {
        return $this->updateProfileAdminAction->execute($admin, $data);
    }

    public function destroy(Admin $admin): void
    {
        $this->deleteAdminAction->execute($admin);
    }

    public function getProfile(string $userId): Admin
    {
        return Admin::with('user')->where('user_id', $userId)->firstOrFail();
    }
}
