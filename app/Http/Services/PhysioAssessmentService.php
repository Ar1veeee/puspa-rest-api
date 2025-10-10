<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\PhysioAssessmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PhysioAssessmentService
{
    protected $assessmentRepository;
    protected $physioAssessmentRepository;

    public function __construct(
        AssessmentRepository       $assessmentRepository,
        PhysioAssessmentRepository $physioAssessmentRepository
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->physioAssessmentRepository = $physioAssessmentRepository;
    }

    public function createAssessmentGuardian(int $assessmentId, array $data)
    {
        $assessment = $this->assessmentRepository->getById($assessmentId);

        if (!$assessment) {
            throw new ModelNotFoundException('Assessment tidak ditemukan.');
        }

        if (!$assessment->fisio) {
            throw new ModelNotFoundException('Penilaian fisio tidak diaktifkan untuk asesmen ini.');
        }

        return $this->physioAssessmentRepository->createAssessmentGuardian(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }
}
