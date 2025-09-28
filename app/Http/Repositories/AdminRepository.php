<?php

namespace App\Http\Repositories;

use App\Models\Admin;

class AdminRepository
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with(['user' => function ($query) {
            $query->select('id', 'username', 'email');
        }])->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getDetailById($id)
    {
        return $this->model->with(['user' => function ($query) {
            $query->select('id', 'username', 'email');
        }])->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $admin = $this->model->find($id);
        if ($admin) {
            $admin->update($data);

            return $admin;
        }

        return null;
    }

    public function delete($id)
    {
        $admin = $this->model->find($id);

        if ($admin) {
            $admin->delete();

            return $admin;
        }

        return null;
    }
}
