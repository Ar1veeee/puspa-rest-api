<?php

namespace App\Http\Repositories;

use App\Models\Assessment;

class AssessmentRepository
{
    protected $model;

    public function __construct(Assessment $model)
    {
        $this->model = $model;
    }

    public function findIdByObservationId(int $observationId)
    {
        return $this->model
            ->where('observation_id', $observationId)
            ->value('id');
    }
}
