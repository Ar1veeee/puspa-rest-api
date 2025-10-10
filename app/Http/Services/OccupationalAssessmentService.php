<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\OccupationalAssessmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OccupationalAssessmentService
{
    protected $assessmentRepository;
    protected $occupationalAssessmentRepository;

    public function __construct(
        AssessmentRepository             $assessmentRepository,
        OccupationalAssessmentRepository $occupationalAssessmentRepository,
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->occupationalAssessmentRepository = $occupationalAssessmentRepository;
    }

    public function createAssessmentGuardian(int $assessmentId, array $data)
    {
        $assessment = $this->assessmentRepository->getById($assessmentId);

        if (!$assessment) {
            throw new ModelNotFoundException('Assessment tidak ditemukan.');
        }

        return DB::transaction(function () use ($assessmentId, $data) {
            $auditory = $this->occupationalAssessmentRepository->createAuditoryCommunication($data);
            $sensoryModality = $this->occupationalAssessmentRepository->createSensoryModality($data);
            $sensoryProcessing = $this->occupationalAssessmentRepository->createSensoryProcessing($data);
            $adlMotor = $this->occupationalAssessmentRepository->createAdlMotorSkill($data);
            $behaviorSocial = $this->occupationalAssessmentRepository->createBehaviorSocial($data);
            $behaviorScale = $this->occupationalAssessmentRepository->createBehaviorScale($data);

            return $this->occupationalAssessmentRepository->createAssessmentGuardian([
                'assessment_id' => $assessmentId,
                'auditory_communication_id' => $auditory->id,
                'sensory_modality_id' => $sensoryModality->id,
                'sensory_processing_screening_id' => $sensoryProcessing->id,
                'adl_motor_skill_id' => $adlMotor->id,
                'behavior_social_id' => $behaviorSocial->id,
                'behavior_scale_id' => $behaviorScale->id,
            ]);
        });
    }
}
