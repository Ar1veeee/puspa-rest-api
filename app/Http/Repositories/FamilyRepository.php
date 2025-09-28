<?php

namespace App\Http\Repositories;

use App\Models\Family;

class FamilyRepository
{
    protected $model;

    public function __construct(Family $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
