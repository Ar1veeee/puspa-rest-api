<?php

namespace App\Http\Repositories;

use App\Models\Guardian;

class GuardianRepository
{
    protected $model;

    public function __construct(Guardian $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function checkExistingEmail(string $email): bool
    {
        return $this->model->where('temp_email', $email)->exists();
    }

    public function updateUserIdByEmail(string $email, string $userId)
    {
        return $this->model->where('temp_email', $email)->update(['user_id' => $userId]);
    }

    public function removeTempEmail(string $userId)
    {
        return $this->model->where('user_id', $userId)->update(['temp_email' => null]);
    }
}
