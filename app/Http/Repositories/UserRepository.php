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

    public function checkExistingUsername(string $username)
    {
        return $this->model->where('username', $username)->first();
    }

    public function checkExistingEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
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
