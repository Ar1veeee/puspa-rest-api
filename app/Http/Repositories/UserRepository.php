<?php

namespace App\Http\Repositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getByIdentifier(string $identifier)
    {
        return $this->model->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();
    }

    public function getAllAdminUnverified()
    {
        return $this->model
            ->with(['admin' => function ($query) {
                $query->select('id', 'user_id', 'admin_name', 'admin_phone');
            }])
            ->where('is_active', 0)
            ->where('role', 'admin')
            ->get();
    }

    public function getAllTherapistUnverified()
    {
        return $this->model
            ->with(['therapist' => function ($query) {
                $query->select('id', 'user_id', 'therapist_name', 'therapist_phone');
            }])
            ->where('is_active', 0)
            ->where('role', 'terapis')
            ->get();
    }

    public function checkExistingUsername(string $username): bool
    {
        return $this->model->where('username', $username)->exists();
    }

    public function checkExistingEmail(string $email): bool
    {
        return $this->model->where('email', $email)->exists();
    }

    public function isUsernameTakenByAnother(string $username, string $idToExclude): bool
    {
        return $this->model->where('username', $username)
            ->where('id', '!=', $idToExclude)
            ->exists();
    }

    public function isEmailTakenByAnother(string $email, string $idToExclude): bool
    {
        return $this->model->where('email', $email)
            ->where('id', '!=', $idToExclude)
            ->exists();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $user = $this->model->find($id);
        if ($user) {
            $user->update($data);

            return $user;
        }

        return null;
    }

    public function activation(string $id)
    {
        return $this->model->find($id)->update([
            'is_active' => 1,
            'email_verified_at' => Carbon::now()
        ]);
    }

}
