<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\PedagogicalAssessmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class PedagogicalAssessmentService
{
    protected $assessmentRepository;
    protected $pedagogicalAssessmentRepository;

    public function __construct(
        AssessmentRepository $assessmentRepository,
        PedagogicalAssessmentRepository $pedagogicalAssessmentRepository,
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->pedagogicalAssessmentRepository = $pedagogicalAssessmentRepository;
    }

    public function createAssessmentGuardian(int $assessmentId, array $data)
    {
        $assessment = $this->assessmentRepository->getById($assessmentId);

        if (!$assessment) {
            throw new ModelNotFoundException('Assessment tidak ditemukan');
        }

        if (!$assessment->paedagog) {
            throw new ModelNotFoundException('Penilaian paedagog tidak diaktifkan untuk asesmen ini.');
        }

        return DB::transaction(function () use ($assessmentId, $data) {
            $academic = $this->pedagogicalAssessmentRepository->createAcademicAspect($data);
            $auditory = $this->pedagogicalAssessmentRepository->createAuditoryImpairmentAspect($data);
            $behavioral = $this->pedagogicalAssessmentRepository->createBehavioralImpairmentAspect($data);
            $cognitive = $this->pedagogicalAssessmentRepository->createCognitiveImpairmentAspect($data);
            $motor = $this->pedagogicalAssessmentRepository->createMotorImpairmentAspect($data);
            $socialCommunication = $this->pedagogicalAssessmentRepository->createSocialCommunicationAspect($data);
            $visual = $this->pedagogicalAssessmentRepository->createVisualImpairmentAspect($data);

            return $this->pedagogicalAssessmentRepository->createAssessmentGuardian([
                'assessment_id' => $assessmentId,
                'academic_aspect_id' => $academic->id,
                'visual_impairment_aspect_id' => $visual->id,
                'auditory_impairment_aspect_id' => $auditory->id,
                'cognitive_impairment_aspect_id' => $cognitive->id,
                'motor_impairment_aspects_id' => $motor->id,
                'behavioral_impairment_aspect_id' => $behavioral->id,
                'social_communication_aspect_id' => $socialCommunication->id,
            ]);
        });
    }
}
