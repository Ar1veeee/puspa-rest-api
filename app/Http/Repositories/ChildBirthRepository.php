<?php

namespace App\Http\Repositories;

use App\Models\ChildBirthHistory;

class ChildBirthRepository
{
    protected $model;

    public function __construct(ChildBirthHistory $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getByAssessmentId(int $assessmentId)
    {
        return $this->model->where('assessment_id', $assessmentId)->first();
    }
}
