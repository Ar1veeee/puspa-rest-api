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

    public function getByFilters(array $filters = [], string $orderDirection = 'asc')
    {
        $query = $this->model->query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['scheduled_date'])) {
            $query->whereDate('scheduled_date', $filters['scheduled_date']);
        }

        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->whereHas('child', function ($childQuery) use ($searchTerm) {
                $childQuery->where('child_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $query->with([
            'child:id,family_id,child_name,child_gender,child_school,child_birth_date',
            'child.family.guardians:id,family_id,guardian_name,guardian_type,guardian_phone',
            'therapist:id,therapist_name'
        ]);

        $query->orderBy('scheduled_date', $orderDirection);

        return $query->get();
    }

    public function update(int $id, array $data): ?bool
    {
        $observation = $this->model->find($id);
        return $observation ? $observation->update($data) : null;
    }
}
