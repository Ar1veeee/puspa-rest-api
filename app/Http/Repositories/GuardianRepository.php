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
}
