<?php

namespace App\Http\Repositories;

use App\Models\ChildEducationHistory;

class ChildEducationRepository
{
    protected $model;

    public function __construct(ChildEducationHistory $model)
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
