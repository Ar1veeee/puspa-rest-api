<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\ChildBirthRepository;
use App\Http\Repositories\ChildPostBirthRepository;
use App\Http\Repositories\ChildPregnancyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ChildPsychosocialRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssessmentService
{
    protected $assessmentRepository;
    protected $guardianRepository;
    protected $childPsychosocialRepository;
    protected $childPregnancyRepository;
    protected $childBirthRepository;
    protected $childPostBirthRequest;

    public function __construct(
        AssessmentRepository $assessmentRepository,
        GuardianRepository $guardianRepository,
        ChildPsychosocialRepository $childPsychosocialRepository,
        ChildPregnancyRepository $childPregnancyRepository,
        ChildBirthRepository $childBirthRepository,
        ChildPostBirthRepository $childPostBirthRequest
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->guardianRepository = $guardianRepository;
        $this->childPsychosocialRepository = $childPsychosocialRepository;
        $this->childPregnancyRepository = $childPregnancyRepository;
        $this->childBirthRepository = $childBirthRepository;
        $this->childPostBirthRequest = $childPostBirthRequest;
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
        return $this->childPostBirthRequest->create(
            array_merge($data, [
                'assessment_id' => $assessmentId,
            ])
        );
    }
}
