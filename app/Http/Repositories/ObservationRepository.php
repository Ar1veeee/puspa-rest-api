<?php

namespace App\Http\Repositories;

use App\Models\Observation;

class ObservationRepository
{
    protected $model;

    public function __construct(Observation $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
