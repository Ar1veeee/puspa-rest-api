<?php

namespace App\Http\Repositories;

use App\Models\User;

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
}
