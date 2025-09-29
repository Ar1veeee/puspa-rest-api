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

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getByPendingStatus()
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
                'child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_type',
                        'guardian_phone',
                    );
                }
            ])
            ->where('status', 'pending')
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByScheduledStatus()
    {
        return $this->model
            ->with([
                'child' => function ($query) {
                    $query->select(
                        'id',
                        'child_name',
                        'child_gender',
                        'child_school',
                        'child_birth_date',
                    );
                }
            ])
            ->where('status', 'scheduled')
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByScheduledDetail(int $id)
    {
        return $this->model
            ->with([
                'child',
                'child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_type',
                        'guardian_phone'
                    );
                }
            ])
            ->find($id);
    }

    public function getByCompletedStatus()
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
                        'child_birth_date',
                    );
                },
                'therapist' => function ($query) {
                    $query->select(
                        'id',
                        'therapist_name',
                    );
                }
            ])
            ->where('status', 'completed')
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByCompletedDetail(int $id)
    {
        return $this->model
            ->with([
                'child' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'child_name',
                        'child_birth_date',
                        'child_gender',
                        'child_school',
                        'child_address'
                    );
                }
            ])
            ->find($id);
    }

    public function update(int $id, array $data): ?bool
    {
        $observation = $this->model->find($id);

        if ($observation) {
            return $observation->update($data);
        }

        return null;
    }
}
