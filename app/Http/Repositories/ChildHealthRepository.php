<?php

namespace App\Http\Repositories;

use App\Models\ChildHealthHistory;

class ChildHealthRepository
{
    protected $model;

    public function __construct(ChildHealthHistory $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
