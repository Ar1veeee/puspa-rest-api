<?php

namespace App\Http\Repositories;

use App\Models\ObservationAnswer;

class ObservationAnswerRepository
{
    protected $model;

    public function __construct(ObservationAnswer $model)
    {
        $this->model = $model;
    }

    public function createMany(array $data)
    {
        return $this->model->insert($data);
    }
}
