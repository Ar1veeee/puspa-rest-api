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

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function setScheduledDate(int $observationId, string $date)
    {
        return $this->model->where('observation_id', $observationId)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled'
        ]);
    }
}
