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
use App\Models\Assessment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
        AssessmentRepository             $assessmentRepository,
        GuardianRepository               $guardianRepository,
        ChildPsychosocialRepository      $childPsychosocialRepository,
        ChildPregnancyRepository         $childPregnancyRepository,
        ChildBirthRepository             $childBirthRepository,
        ChildPostBirthRepository         $childPostBirthRepository,
        ChildHealthRepository            $childHealthRepository,
        ChildEducationRepository         $childEducationRepository,
        PhysioAssessmentRepository       $physioAssessmentRepository,
        SpeechAssessmentRepository       $speechAssessmentRepository,
        OccupationalAssessmentRepository $occupationalAssessmentRepository,
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

    public function getChildrenAssessment(string $userId)
    {
        return $this->guardianRepository->getAssessments($userId);
    }

    public function getGeneral(Assessment $assessment)
    {
        $assessment->load([
            'child.family.guardians',
            'psychosocialHistory',
            'pregnancyHistory',
            'birthHistory',
            'postBirthHistory',
            'healthHistory',
            'educationHistory',
        ]);

        return $assessment;
    }

    public function getPhysioGuardian(Assessment $assessment)
    {
        $physioData = $this->physioAssessmentRepository->getAssessmentGuardianByAssessmentId($assessment->id);
        if (!$physioData) {
            throw new ModelNotFoundException('Data assessment fisio tidak ditemukan.');
        }

        return $physioData;
    }

    public function getSpeechGuardian(Assessment $assessment)
    {
        $speechData = $this->speechAssessmentRepository->getAssessmentGuardianByAssessmentId($assessment->id);
        if (!$speechData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $speechData;
    }

    public function getOccupationalGuardian(Assessment $assessment)
    {
        $occupationalData = $this->occupationalAssessmentRepository->getAllAssessmentGuardian($assessment->id);
        if (!$occupationalData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $occupationalData;
    }

    public function getPedagogicalGuardian(Assessment $assessment)
    {
        $pedagogicalData = $this->pedagogicalAssessmentRepository->getAllAssessmentGuardian($assessment->id);
        if (!$pedagogicalData) {
            throw new ModelNotFoundException('Data assessment paedagog tidak ditemukan.');
        }

        return $pedagogicalData;
    }

    public function createGeneralData(Assessment $assessment, array $data)
    {
        return DB::transaction(function () use ($assessment, $data) {
            $this->childPsychosocialRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
            $this->childPregnancyRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
            $this->childBirthRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
            $this->childPostBirthRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
            $this->childHealthRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
            $this->childEducationRepository->create(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                ])
            );
        });
    }
}
