<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AdminService
{
    protected $userRepository;
    protected $adminRepository;

    public function __construct(UserRepository $userRepository, AdminRepository $adminRepository)
    {
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * Get all admins
     *
     * @return Collection
     */
    public function getAllAdmin(): Collection
    {
        return $this->adminRepository->getAll();
    }

    /**
     * Get admin detail by ID
     *
     * @param string $id
     * @return Collection|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Model
     * @throws ModelNotFoundException
     */
    public function getAdminDetail(string $id)
    {
        return $this->adminRepository->getDetailByIdOrFail($id);
    }

    /**
     * Create new admin
     *
     * @param array $data
     * @return Admin
     * @throws ValidationException
     */
    public function createAdmin(array $data): Admin
    {
        $this->validateUniqueCredentials($data);

        DB::beginTransaction();
        try {
            $user = $this->createUserForAdmin($data);
            $admin = $this->createAdminProfile($user->id, $data);

            DB::commit();

            return $admin->load('user');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update existing admin
     *
     * @param array $data
     * @param string $id
     * @return Admin
     * @throws ModelNotFoundException|ValidationException
     */
    public function updateAdmin(array $data, string $id): Admin
    {
        $admin = $this->findAdminOrFail($id);
        $user = $this->findUserOrFail($admin->user_id);

        $this->validateUpdateCredentials($data, $user);

        DB::beginTransaction();
        try {
            $this->updateUserData($user, $data);
            $this->updateAdminData($admin, $data);

            DB::commit();

            return $admin->fresh()->load('user');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete admin and associated user
     *
     * @param string $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteAdmin(string $id): bool
    {
        $admin = $this->findAdminOrFail($id);
        $userId = $admin->user_id;

        DB::beginTransaction();
        try {
            $this->adminRepository->delete($id);

            $this->userRepository->delete($userId);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== Private Helper Methods ==========

    /**
     * Find admin or throw exception
     *
     * @param string $id
     * @return Admin
     * @throws ModelNotFoundException
     */
    private function findAdminOrFail(string $id): Admin
    {
        $admin = $this->adminRepository->getById($id);

        if (!$admin) {
            throw new ModelNotFoundException('Data admin tidak ditemukan.');
        }

        return $admin;
    }

    /**
     * Find user or throw exception
     *
     * @param string $id
     * @return \App\Models\User
     * @throws ModelNotFoundException
     */
    private function findUserOrFail(string $id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new ModelNotFoundException('User tidak ditemukan.');
        }

        return $user;
    }

    /**
     * Create user account for admin
     *
     * @param array $data
     * @return \App\Models\User
     */
    private function createUserForAdmin(array $data)
    {
        return $this->userRepository->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'is_active' => false,
        ]);
    }

    /**
     * Create admin profile
     *
     * @param string $userId
     * @param array $data
     * @return Admin
     */
    private function createAdminProfile(string $userId, array $data): Admin
    {
        return $this->adminRepository->create([
            'user_id' => $userId,
            'admin_name' => $data['admin_name'],
            'admin_phone' => $data['admin_phone'],
        ]);
    }

    /**
     * Validate unique credentials for new admin
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validateUniqueCredentials(array $data): void
    {
        if ($this->userRepository->checkExistingUsername($data['username'])) {
            throw ValidationException::withMessages([
                'username' => ['Username sudah digunakan.'],
            ]);
        }

        if ($this->userRepository->checkExistingEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah digunakan.'],
            ]);
        }
    }

    /**
     * Validate credentials for admin update
     *
     * @param array $data
     * @param \App\Models\User $user
     * @return void
     * @throws ValidationException
     */
    private function validateUpdateCredentials(array $data, $user): void
    {
        if (isset($data['username']) && $data['username'] !== $user->username) {
            if ($this->userRepository->isUsernameTakenByAnother($data['username'], $user->id)) {
                throw ValidationException::withMessages([
                    'username' => ['Username sudah digunakan.'],
                ]);
            }
        }

        if (isset($data['email']) && $data['email'] !== $user->email) {
            if ($this->userRepository->isEmailTakenByAnother($data['email'], $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['Email sudah digunakan.'],
                ]);
            }
        }
    }

    /**
     * Update user data
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return void
     */
    private function updateUserData($user, array $data): void
    {
        $userData = array_filter([
            'username' => $data['username'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
        ], fn($value) => $value !== null);

        if (!empty($userData)) {
            $this->userRepository->update($userData, $user->id);
        }
    }

    /**
     * Update admin data
     *
     * @param Admin $admin
     * @param array $data
     * @return void
     */
    private function updateAdminData(Admin $admin, array $data): void
    {
        $adminData = array_filter([
            'admin_name' => $data['admin_name'] ?? null,
            'admin_phone' => $data['admin_phone'] ?? null,
        ], fn($value) => $value !== null);

        if (!empty($adminData)) {
            $this->adminRepository->update($adminData, $admin->id);
        }
    }
}
