<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\SpeechAssessmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SpeechAssessmentService
{
    protected $assessmentRepository;
    protected $speechAssessmentGuardianRepository;

    public function __construct(
        AssessmentRepository       $assessmentRepository,
        SpeechAssessmentRepository $speechAssessmentGuardianRepository
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->speechAssessmentGuardianRepository = $speechAssessmentGuardianRepository;
    }

    public function createAssessmentGuardian(int $assessmentId, array $data)
    {
        $assessment = $this->assessmentRepository->getById($assessmentId);

        if (!$assessment) {
            throw new ModelNotFoundException('Assessment tidak ditemukan.');
        }

        return $this->speechAssessmentGuardianRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }
}
