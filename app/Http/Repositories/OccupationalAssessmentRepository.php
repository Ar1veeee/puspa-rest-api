<?php

namespace App\Http\Repositories;

use App\Models\OccuAssessmentTherapist;
use App\Models\OccuBalanceCoordination;
use App\Models\OccuBodilySelfSense;
use App\Models\OccuConcentrationProblemSolving;
use App\Models\OccuConceptKnowledge;
use App\Models\OccuMotoricPlanning;
use App\Models\OccupationalAdlMotorSkill;
use App\Models\OccupationalAssessmentGuardian;
use App\Models\OccupationalAuditoryCommunication;
use App\Models\OccupationalBehaviorScale;
use App\Models\OccupationalBehaviorSocial;
use App\Models\OccupationalSensoryModalityTest;
use App\Models\OccupationalSensoryProcessingScreening;

class OccupationalAssessmentRepository
{
    // Guardian Repo
    protected $modelAssessmentGuardian;
    protected $modelAdlMotorSkill;
    protected $modelAuditoryCommunication;
    protected $modelBehaviorScale;
    protected $modelBehaviorSocial;
    protected $modelSensoryModality;
    protected $modelSensoryProcessing;

    // Therapist Repo
    protected $modelAssessmentTherapist;
    protected $modelBalanceCoordination;
    protected $modelBodilySelfSense;
    protected $modelConcentrationProblemSolving;
    protected $modelConceptKnowledge;
    protected $modelMotoricPlanning;

    public function __construct(
        OccupationalAssessmentGuardian         $modelAssessmentGuardian,
        OccupationalAdlMotorSkill              $modelAdlMotorSkill,
        OccupationalAuditoryCommunication      $modelAuditoryCommunication,
        OccupationalBehaviorScale              $modelBehaviorScale,
        OccupationalBehaviorSocial             $modelBehaviorSocial,
        OccupationalSensoryModalityTest        $modelSensoryModality,
        OccupationalSensoryProcessingScreening $modelSensoryProcessing,

        OccuAssessmentTherapist                $modelAssessmentTherapist,
        OccuBalanceCoordination                $modelBalanceCoordination,
        OccuBodilySelfSense                    $modelBodilySelfSense,
        OccuConcentrationProblemSolving        $modelConcentrationProblemSolving,
        OccuConceptKnowledge                   $modelConceptKnowledge,
        OccuMotoricPlanning                    $modelMotoricPlanning,
    )
    {
        $this->modelAssessmentGuardian = $modelAssessmentGuardian;
        $this->modelAdlMotorSkill = $modelAdlMotorSkill;
        $this->modelAuditoryCommunication = $modelAuditoryCommunication;
        $this->modelBehaviorScale = $modelBehaviorScale;
        $this->modelBehaviorSocial = $modelBehaviorSocial;
        $this->modelSensoryModality = $modelSensoryModality;
        $this->modelSensoryProcessing = $modelSensoryProcessing;

        $this->modelAssessmentTherapist = $modelAssessmentTherapist;
        $this->modelBalanceCoordination = $modelBalanceCoordination;
        $this->modelBodilySelfSense = $modelBodilySelfSense;
        $this->modelConcentrationProblemSolving = $modelConcentrationProblemSolving;
        $this->modelConceptKnowledge = $modelConceptKnowledge;
        $this->modelMotoricPlanning = $modelMotoricPlanning;
    }

    // Guardian Repo
    public function createAssessmentGuardian(array $data)
    {
        return $this->modelAssessmentGuardian->create($data);
    }

    public function createAdlMotorSkill(array $data)
    {
        return $this->modelAdlMotorSkill->create($data);
    }

    public function createAuditoryCommunication(array $data)
    {
        return $this->modelAuditoryCommunication->create($data);
    }

    public function createBehaviorScale(array $data)
    {
        return $this->modelBehaviorScale->create($data);
    }

    public function createBehaviorSocial(array $data)
    {
        return $this->modelBehaviorSocial->create($data);
    }

    public function createSensoryModality(array $data)
    {
        return $this->modelSensoryModality->create($data);
    }

    public function createSensoryProcessing(array $data)
    {
        return $this->modelSensoryProcessing->create($data);
    }

    // Therapist Repo
    public function createAssessmentTherapist(array $data)
    {
        return $this->modelAssessmentTherapist->create($data);
    }

    public function createBalanceCoordination(array $data)
    {
        return $this->modelBalanceCoordination->create($data);
    }

    public function createBodilySelfSense(array $data)
    {
        return $this->modelBodilySelfSense->create($data);
    }

    public function createConcentrationProblemSolving(array $data)
    {
        return $this->modelConcentrationProblemSolving->create($data);
    }

    public function createConceptKnowledge(array $data)
    {
        return $this->modelConceptKnowledge->create($data);
    }

    public function createMotoricPlanning(array $data)
    {
        return $this->modelMotoricPlanning->create($data);
    }
}
