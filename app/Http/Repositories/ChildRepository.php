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

    public function getAll()
    {
        return $this->model->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getDetailById(string $id)
    {
        return $this->model->with('family.guardians')->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
