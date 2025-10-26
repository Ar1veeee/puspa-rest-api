<?php

namespace App\Http\Repositories;

use App\Models\PhysioAssessmentGuardian;
use App\Models\PhysioAssessmentTherapist;
use App\Models\PhysioGeneralExamination;
use App\Models\PhysioGrossMotorExamination;
use App\Models\PhysioJointLaxityTest;
use App\Models\PhysioMusclePalpation;
use App\Models\PhysioMuscleStrengthExamination;
use App\Models\PhysioPhysiotherapyDiagnosis;
use App\Models\PhysioPlayFunctionTest;
use App\Models\PhysioReflexExamination;
use App\Models\PhysioSensoryExamination;
use App\Models\PhysioSpasticityExamination;
use App\Models\PhysioSpasticityType;
use App\Models\PhysioSystemAnamnesis;

class PhysioAssessmentRepository
{
    protected $modelPhysioAssessmentGuardian;
    protected $modelPhysioAssessmentTherapist;
    protected $modelPhysioGeneralExamination;
    protected $modelPhysioSystemAnamnesis;
    protected $modelPhysioSensoryExamination;
    protected $modelPhysioReflexExamination;
    protected $modelPhysioMuscleStrengthExamination;
    protected $modelPhysioSpasticityExamination;
    protected $modelPhysioJointLaxityTest;
    protected $modelPhysioGrossMotorExamination;
    protected $modelPhysioMusclePalpation;
    protected $modelPhysioSpasticityType;
    protected $modelPhysioPlayFunctionTest;
    protected $modelPhysioPhysiotherapyDiagnosis;

    public function __construct(
        PhysioAssessmentGuardian        $modelPhysioAssessmentGuardian,
        PhysioAssessmentTherapist       $modelPhysioAssessmentTherapist,
        PhysioGeneralExamination        $modelPhysioGeneralExamination,
        PhysioSystemAnamnesis           $modelPhysioSystemAnamnesis,
        PhysioSensoryExamination        $modelPhysioSensoryExamination,
        PhysioReflexExamination         $modelPhysioReflexExamination,
        PhysioMuscleStrengthExamination $modelPhysioMuscleStrengthExamination,
        PhysioSpasticityExamination     $modelPhysioSpasticityExamination,
        PhysioJointLaxityTest           $modelPhysioJointLaxityTest,
        PhysioGrossMotorExamination     $modelPhysioGrossMotorExamination,
        PhysioMusclePalpation           $modelPhysioMusclePalpation,
        PhysioSpasticityType            $modelPhysioSpasticityType,
        PhysioPlayFunctionTest          $modelPhysioPlayFunctionTest,
        PhysioPhysiotherapyDiagnosis    $modelPhysioPhysiotherapyDiagnosis,
    )
    {
        $this->modelPhysioAssessmentGuardian = $modelPhysioAssessmentGuardian;
        $this->modelPhysioAssessmentTherapist = $modelPhysioAssessmentTherapist;
        $this->modelPhysioGeneralExamination = $modelPhysioGeneralExamination;
        $this->modelPhysioSystemAnamnesis = $modelPhysioSystemAnamnesis;
        $this->modelPhysioSensoryExamination = $modelPhysioSensoryExamination;
        $this->modelPhysioReflexExamination = $modelPhysioReflexExamination;
        $this->modelPhysioMuscleStrengthExamination = $modelPhysioMuscleStrengthExamination;
        $this->modelPhysioSpasticityExamination = $modelPhysioSpasticityExamination;
        $this->modelPhysioJointLaxityTest = $modelPhysioJointLaxityTest;
        $this->modelPhysioGrossMotorExamination = $modelPhysioGrossMotorExamination;
        $this->modelPhysioMusclePalpation = $modelPhysioMusclePalpation;
        $this->modelPhysioSpasticityType = $modelPhysioSpasticityType;
        $this->modelPhysioPlayFunctionTest = $modelPhysioPlayFunctionTest;
        $this->modelPhysioPhysiotherapyDiagnosis = $modelPhysioPhysiotherapyDiagnosis;
    }

    public function createAssessmentGuardian(array $data)
    {
        return $this->modelPhysioAssessmentGuardian->create($data);
    }

    public function createAssessmentTherapist(array $data)
    {
        return $this->modelPhysioAssessmentTherapist->create($data);
    }

    public function createGeneralExamination(array $data)
    {
        return $this->modelPhysioGeneralExamination->create($data);
    }

    public function createSystemAnamnesis(array $data)
    {
        return $this->modelPhysioSystemAnamnesis->create($data);
    }

    public function createSensoryExamination(array $data)
    {
        return $this->modelPhysioSensoryExamination->create($data);
    }

    public function createReflexExamination(array $data)
    {
        return $this->modelPhysioReflexExamination->create($data);
    }

    public function createMuscleStrengthExamination(array $data)
    {
        return $this->modelPhysioMuscleStrengthExamination->create($data);
    }

    public function createSpasticityExamination(array $data)
    {
        return $this->modelPhysioSpasticityExamination->create($data);
    }

    public function createJointLaxityTest(array $data)
    {
        return $this->modelPhysioJointLaxityTest->create($data);
    }

    public function createGrossMotorExamination(array $data)
    {
        return $this->modelPhysioGrossMotorExamination->create($data);
    }

    public function createMusclePalpation(array $data)
    {
        return $this->modelPhysioMusclePalpation->create($data);
    }

    public function createSpasticityType(array $data)
    {
        return $this->modelPhysioSpasticityType->create($data);
    }

    public function createPlayFunctionTest(array $data)
    {
        return $this->modelPhysioPlayFunctionTest->create($data);
    }

    public function createPhysiotherapyDiagnosis(array $data)
    {
        return $this->modelPhysioPhysiotherapyDiagnosis->create($data);
    }
}
