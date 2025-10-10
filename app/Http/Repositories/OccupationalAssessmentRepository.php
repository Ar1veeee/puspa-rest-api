<?php

namespace App\Http\Repositories;

use App\Models\OccupationalAdlMotorSkill;
use App\Models\OccupationalAssessmentGuardian;
use App\Models\OccupationalAuditoryCommunication;
use App\Models\OccupationalBehaviorScale;
use App\Models\OccupationalBehaviorSocial;
use App\Models\OccupationalSensoryModalityTest;
use App\Models\OccupationalSensoryProcessingScreening;

class OccupationalAssessmentRepository
{
    protected $modelAssessmentGuardian;
    protected $modelAdlMotorSkill;
    protected $modelAuditoryCommunication;
    protected $modelBehaviorScale;
    protected $modelBehaviorSocial;
    protected $modelSensoryModality;
    protected $modelSensoryProcessing;

    public function __construct(
        OccupationalAssessmentGuardian $modelAssessmentGuardian,
        OccupationalAdlMotorSkill $modelAdlMotorSkill,
        OccupationalAuditoryCommunication $modelAuditoryCommunication,
        OccupationalBehaviorScale $modelBehaviorScale,
        OccupationalBehaviorSocial $modelBehaviorSocial,
        OccupationalSensoryModalityTest $modelSensoryModality,
        OccupationalSensoryProcessingScreening $modelSensoryProcessing
    )
    {
        $this->modelAssessmentGuardian = $modelAssessmentGuardian;
        $this->modelAdlMotorSkill = $modelAdlMotorSkill;
        $this->modelAuditoryCommunication = $modelAuditoryCommunication;
        $this->modelBehaviorScale = $modelBehaviorScale;
        $this->modelBehaviorSocial = $modelBehaviorSocial;
        $this->modelSensoryModality = $modelSensoryModality;
        $this->modelSensoryProcessing = $modelSensoryProcessing;
    }

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
}
