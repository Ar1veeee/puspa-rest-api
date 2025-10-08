<?php

namespace App\Http\Repositories;

use App\Models\ChildPregnancyHistory;

class ChildPregnancyRepository
{
    protected $model;

    public function __construct(ChildPregnancyHistory $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
