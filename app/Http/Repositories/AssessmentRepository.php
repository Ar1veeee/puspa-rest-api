<?php

namespace App\Http\Repositories;

use App\Models\Assessment;
use Illuminate\Support\Collection;

class AssessmentRepository
{
    protected $model;

    public function __construct(Assessment $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function getByScheduledType(string $status, $assessmentType)
    {
        $query = $this->model->query();

        $validTypes = ['fisio', 'okupasi', 'wicara', 'paedagog'];
        if (!in_array($assessmentType, $validTypes)) {
            return new Collection();
        }

        return $query
            ->with([
                'child' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'child_name',
                        'child_birth_date',
                        'child_gender'
                    );
                },
                'child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_phone'
                    );
                }
            ])
            ->where('status', $status)
            ->where($assessmentType, true)
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function setScheduledDate(int $observationId, string $date)
    {
        return $this->model->where('observation_id', $observationId)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled'
        ]);
    }
}
