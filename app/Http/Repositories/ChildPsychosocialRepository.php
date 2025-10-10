<?php

namespace App\Http\Repositories;

use App\Models\ChildPsychosocialHistory;

class ChildPsychosocialRepository
{
    protected $model;

    public function __construct(ChildPsychosocialHistory $model)
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
