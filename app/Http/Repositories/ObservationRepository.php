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
        return $this->getStatusQuery('pending')
            ->with([
                'child.family.guardians' => function ($query) {
                    $query->select('id', 'family_id', 'guardian_name', 'guardian_type', 'guardian_phone');
                }
            ])
            ->get();
    }

    public function getByScheduledStatus()
    {
        return $this->getStatusQuery('scheduled')->get();
    }

    public function getByCompletedStatus()
    {
        return $this->getStatusQuery('completed')
            ->with([
                'therapist' => function ($query) {
                    $query->select('id', 'therapist_name');
                }
            ])
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
                },
                'child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_type',
                    );
                }
            ])
            ->find($id);
    }

    public function getDetailAnswer(int $id)
    {
        return $this->model->with([
            'observation_answers.observation_question' => function ($query) {
                $query->select('id', 'question_number', 'question_text');
            }
        ])
            ->find($id);
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
