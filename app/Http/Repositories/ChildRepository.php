<?php

namespace App\Http\Repositories;

use App\Models\Child;

class ChildRepository
{
    protected $model;

    public function __construct(Child $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
