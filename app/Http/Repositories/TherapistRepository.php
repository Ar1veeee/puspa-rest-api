<?php

namespace App\Http\Repositories;

use App\Models\Therapist;

class TherapistRepository
{
    protected $model;

    public function __construct(Therapist $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->whereHas('user', function ($query) {
            $query->where('is_active', 1);
        })
            ->with(['user' => function ($query) {
                $query->select('id', 'username', 'email', 'is_active');
            }])->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getDetailByIdOrFail($id)
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
        $therapist = $this->model->find($id);
        if ($therapist) {
            $therapist->update($data);

            return $therapist;
        }

        return null;
    }

    public function delete($id)
    {
        $therapist = $this->model->find($id);

        if ($therapist) {
            $therapist->delete();

            return $therapist;
        }

        return null;
    }
}
