<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminService
{
    protected $userRepository;

    protected $adminRepository;

    public function __construct(UserRepository $userRepository, AdminRepository $adminRepository)
    {
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
    }

    public function getAllAdmin()
    {
        $admins = $this->adminRepository->getAll();
        $adminsData = [];

        foreach ($admins as $admin) {
            $adminsData[] = [
                'id' => $admin->id,
                'user_id' => $admin->user_id,
                'email' => $admin->user->email,
                'username' => $admin->user->username,
                'admin_name' => $admin->admin_name,
                'admin_section' => $admin->admin_section,
                'admin_phone' => $admin->admin_phone,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ];
        }

        return $adminsData;
    }

    public function getAdminDetail(string $id)
    {
        $admin = $this->adminRepository->getDetailById($id);

        if (! $admin) {
            throw new ModelNotFoundException('Data admin tidak ditemukan.');
        }

        return [
            'id' => $admin->id,
            'user_id' => $admin->user_id,
            'email' => $admin->user->email,
            'username' => $admin->user->username,
            'admin_name' => $admin->admin_name,
            'admin_section' => $admin->admin_section,
            'admin_phone' => $admin->admin_phone,
            'created_at' => $admin->created_at,
            'updated_at' => $admin->updated_at,
        ];
    }

    public function createAdmin(array $data): void
    {
        $existingUsername = $this->userRepository->checkExistingUsername($data['username']);
        if ($existingUsername) {
            throw ValidationException::withMessages([
                'nama_pengguna' => ['Nama pengguna sudah digunakan'],
            ]);
        }

        $existingEmail = $this->userRepository->checkExistingEmail($data['email']);
        if ($existingEmail) {
            throw ValidationException::withMessages([
                'email' => ['Email sudah digunakan'],
            ]);
        }

        DB::transaction(function () use ($data) {
            $userData = [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
            ];

            $newUser = $this->userRepository->create($userData);

            $userId = $newUser->id;

            $adminData = [
                'user_id' => $userId,
                'admin_name' => $data['admin_name'],
                'admin_phone' => $data['admin_phone'],
            ];

            $this->adminRepository->create($adminData);
        });
    }

    public function updateAdmin(array $data, string $id)
    {
        $admin = $this->adminRepository->getById($id);
        if (! $admin) {
            throw new ModelNotFoundException('Data admin tidak ditemukan.');
        }

        $user = $this->userRepository->getById($admin->user_id);
        if (! $user) {
            throw new ModelNotFoundException('Data user terkait tidak ditemukan.');
        }

        if (isset($data['username']) && $data['username'] !== $user->username) {
            if ($this->userRepository->isUsernameTakenByAnother($data['username'], $user->id)) {
                throw ValidationException::withMessages([
                    'nama_pengguna' => ['Nama pengguna sudah digunakan'],
                ]);
            }
        }

        if (isset($data['email']) && $data['email'] !== $user->email) {
            if ($this->userRepository->isEmailTakenByAnother($data['email'], $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['Email sudah digunakan'],
                ]);
            }
        }

        $userData = [];
        if (isset($data['username'])) {
            $userData['username'] = $data['username'];
        }
        if (isset($data['email'])) {
            $userData['email'] = $data['email'];
        }
        if (isset($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }
        if (! empty($userData)) {
            $this->userRepository->update($userData, $user->id);
        }

        $adminData = [];
        if (isset($data['admin_name'])) {
            $adminData['admin_name'] = $data['admin_name'];
        }
        if (isset($data['admin_phone'])) {
            $adminData['admin_phone'] = $data['admin_phone'];
        }
        if (! empty($adminData)) {
            $this->adminRepository->update($adminData, $id);
        }
    }

    public function deleteAdmin(string $id)
    {
        $admin = $this->adminRepository->getById($id);
        if (! $admin) {
            throw new ModelNotFoundException('Data admin tidak ditemukan.');
        }

        return $this->adminRepository->delete($id);
    }
}
