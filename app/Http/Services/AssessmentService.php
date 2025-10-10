<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\ChildBirthRepository;
use App\Http\Repositories\ChildEducationRepository;
use App\Http\Repositories\ChildHealthRepository;
use App\Http\Repositories\ChildPostBirthRepository;
use App\Http\Repositories\ChildPregnancyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ChildPsychosocialRepository;
use App\Http\Repositories\OccupationalAssessmentRepository;
use App\Http\Repositories\PedagogicalAssessmentRepository;
use App\Http\Repositories\PhysioAssessmentRepository;
use App\Http\Repositories\SpeechAssessmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssessmentService
{
    protected $assessmentRepository;
    protected $guardianRepository;
    protected $childPsychosocialRepository;
    protected $childPregnancyRepository;
    protected $childBirthRepository;
    protected $childPostBirthRepository;
    protected $childHealthRepository;
    protected $childEducationRepository;
    protected $physioAssessmentRepository;
    protected $speechAssessmentRepository;
    protected $occupationalAssessmentRepository;
    protected $pedagogicalAssessmentRepository;

    public function __construct(
        AssessmentRepository        $assessmentRepository,
        GuardianRepository          $guardianRepository,
        ChildPsychosocialRepository $childPsychosocialRepository,
        ChildPregnancyRepository    $childPregnancyRepository,
        ChildBirthRepository        $childBirthRepository,
        ChildPostBirthRepository    $childPostBirthRepository,
        ChildHealthRepository       $childHealthRepository,
        ChildEducationRepository    $childEducationRepository,
        PhysioAssessmentRepository  $physioAssessmentRepository,
        SpeechAssessmentRepository  $speechAssessmentRepository,
        OccupationalAssessmentRepository  $occupationalAssessmentRepository,
        PedagogicalAssessmentRepository  $pedagogicalAssessmentRepository,
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->guardianRepository = $guardianRepository;
        $this->childPsychosocialRepository = $childPsychosocialRepository;
        $this->childPregnancyRepository = $childPregnancyRepository;
        $this->childBirthRepository = $childBirthRepository;
        $this->childPostBirthRepository = $childPostBirthRepository;
        $this->childHealthRepository = $childHealthRepository;
        $this->childEducationRepository = $childEducationRepository;
        $this->physioAssessmentRepository = $physioAssessmentRepository;
        $this->speechAssessmentRepository = $speechAssessmentRepository;
        $this->occupationalAssessmentRepository = $occupationalAssessmentRepository;
        $this->pedagogicalAssessmentRepository = $pedagogicalAssessmentRepository;
    }

    public function getAssessmentDetail(int $id)
    {
        $assessment = $this->assessmentRepository->getById($id);

        if (!$assessment) {
            throw new ModelNotFoundException('Data assessment tidak ditemukan.');
        }

        return $assessment;
    }

    public function getChildrenAssessment(string $userId)
    {
        return $this->guardianRepository->getAssessments($userId);
    }

    public function getGeneral(int $id)
    {
        $parentData = $this->assessmentRepository->getParentDataById($id);
        $psychosocialData = $this->childPsychosocialRepository->getByAssessmentId($id);
        $pregnancyData = $this->childPregnancyRepository->getByAssessmentId($id);
        $birthData = $this->childBirthRepository->getByAssessmentId($id);
        $postBirthData = $this->childPostBirthRepository->getByAssessmentId($id);
        $healthData = $this->childHealthRepository->getByAssessmentId($id);
        $educationData = $this->childEducationRepository->getByAssessmentId($id);

        return [
            'assessment_details' => $parentData,
            'psychosocial' => $psychosocialData,
            'pregnancy' => $pregnancyData,
            'birth' => $birthData,
            'post_birth' => $postBirthData,
            'health' => $healthData,
            'education' => $educationData,
        ];
    }

    public function getPhysioGuardian(int $id)
    {
        $assessment = $this->assessmentRepository->getById($id);
        if (!$assessment) {
            throw new ModelNotFoundException('Data assessment tidak ditemukan.');
        }

        $physioData = $this->physioAssessmentRepository->getAssessmentGuardianByAssessmentId($id);
        if (!$physioData) {
            throw new ModelNotFoundException('Data assessment fisio tidak ditemukan.');
        }

        return $physioData;
    }

    public function getSpeechGuardian(int $id)
    {
        $assessment = $this->assessmentRepository->getById($id);
        if (!$assessment) {
            throw new ModelNotFoundException('Data assessment tidak ditemukan.');
        }

        $speechData = $this->speechAssessmentRepository->getAssessmentGuardianByAssessmentId($id);
        if (!$speechData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $speechData;
    }

    public function getOccupationalGuardian(int $id)
    {
        $assessment = $this->assessmentRepository->getById($id);
        if (!$assessment) {
            throw new ModelNotFoundException('Data assessment tidak ditemukan.');
        }

        $occupationalData = $this->occupationalAssessmentRepository->getAllAssessmentGuardian($id);
        if (!$occupationalData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $occupationalData;
    }

    public function getPedagogicalGuardian(int $id)
    {
        $assessment = $this->assessmentRepository->getById($id);
        if (!$assessment) {
            throw new ModelNotFoundException('Data assessment tidak ditemukan.');
        }

        $pedagogicalData = $this->pedagogicalAssessmentRepository->getAllAssessmentGuardian($id);
        if (!$pedagogicalData) {
            throw new ModelNotFoundException('Data assessment paedagog tidak ditemukan.');
        }

        return $pedagogicalData;
    }

    public function createChildPsychosocialHistory(int $assessmentId, array $data)
    {
        return $this->childPsychosocialRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }

    public function createChildPregnancyHistory(int $assessmentId, array $data)
    {
        return $this->childPregnancyRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }

    public function createChildBirthHistory(int $assessmentId, array $data)
    {
        return $this->childBirthRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }

    public function createChildPostBirthHistory(int $assessmentId, array $data)
    {
        return $this->childPostBirthRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }

    public function createChildHealthHistory(int $assessmentId, array $data)
    {
        return $this->childHealthRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }

    public function createChildEducationHistory(int $assessmentId, array $data)
    {
        return $this->childEducationRepository->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }
}
