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

    public function model(): Observation
    {
        return $this->model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?bool
    {
        $observation = $this->model->find($id);
        return $observation ? $observation->update($data) : null;
    }

    private function getStatusQuery(string $status)
    {
        return $this->model
            ->with([
                'child' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'child_name',
                        'child_gender',
                        'child_school',
                        'child_birth_date'
                    );
                },
            ])
            ->where('status', $status)
            ->orderBy('scheduled_date', 'asc');
    }
}
