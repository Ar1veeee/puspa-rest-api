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
        return $this->model->whereHas('user', function ($query) {
            $query->where('is_active', 1);
        })
            ->with(['user' => function ($query) {
                $query->select('id', 'username', 'email', 'is_active')
                    ->where('is_active', 1);
            }])
            ->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getDetailByIdOrFail($id)
    {
        return $this->model->with(['user' => function ($query) {
            $query->select('id', 'username', 'email');
        }])->findOrFail($id);
    }

    public function findByUserId(string $user_id)
    {
        return $this->model->with('user')->where('user_id', $user_id)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $admin = $this->model->find($id);
        if ($admin) {
            return $admin->update($data);
        }

        return false;
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
