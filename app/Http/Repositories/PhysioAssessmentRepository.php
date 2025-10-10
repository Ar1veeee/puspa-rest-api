<?php

namespace App\Http\Repositories;

use App\Models\PhysioAssessmentGuardian;

class PhysioAssessmentRepository
{
    protected $modelPhysioAssessmentGuardian;

    public function __construct(PhysioAssessmentGuardian $modelPhysioAssessmentGuardian)
    {
        $this->modelPhysioAssessmentGuardian = $modelPhysioAssessmentGuardian;
    }

    public function createAssessmentGuardian(array $data)
    {
        return $this->modelPhysioAssessmentGuardian->create($data);
    }
}
