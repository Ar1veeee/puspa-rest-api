<?php

namespace App\Http\Repositories;

use App\Models\SpeechAssessmentGuardian;

class SpeechAssessmentRepository
{
    protected $modelSpeechAssessmentGuardian;

    public function __construct(SpeechAssessmentGuardian $modelSpeechAssessmentGuardian)
    {
        $this->modelSpeechAssessmentGuardian = $modelSpeechAssessmentGuardian;
    }

    public function create(array $data)
    {
        return $this->modelSpeechAssessmentGuardian->create($data);
    }

    public function getAssessmentGuardianByAssessmentId(int $assessmentId)
    {
        return $this->modelSpeechAssessmentGuardian->where('assessment_id', $assessmentId)->first();
    }
}
