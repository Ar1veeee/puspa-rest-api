<?php

namespace App\Http\Repositories;

use App\Models\PedagogicalAcademicAspect;
use App\Models\PedagogicalAssessmentGuardian;
use App\Models\PedagogicalAuditoryImpairmentAspect;
use App\Models\PedagogicalBehavioralImpairmentAspect;
use App\Models\PedagogicalCognitiveImpairmentAspect;
use App\Models\PedagogicalMotorImpairmentAspect;
use App\Models\PedagogicalSocialCommunicationAspect;
use App\Models\PedagogicalVisualImpairmentAspect;

class PedagogicalAssessmentRepository
{
    protected $modelAssessmentGuardian;
    protected $modelAcademicAspect;
    protected $modelAuditoryAspect;
    protected $modelBehavioralAspect;
    protected $modelCognitiveAspect;
    protected $modelMotorAspect;
    protected $modelVisualAspect;
    protected $modelSocialCommunicationAspect;

    public function __construct(
        PedagogicalAssessmentGuardian         $modelAssessmentGuardian,
        PedagogicalAcademicAspect             $modelAcademicAspect,
        PedagogicalAuditoryImpairmentAspect   $modelAuditoryAspect,
        PedagogicalBehavioralImpairmentAspect $modelBehavioralAspect,
        PedagogicalCognitiveImpairmentAspect  $modelCognitiveAspect,
        PedagogicalMotorImpairmentAspect      $modelMotorAspect,
        PedagogicalVisualImpairmentAspect     $modelVisualAspect,
        PedagogicalSocialCommunicationAspect  $modelSocialCommunicationAspect
    )
    {
        $this->modelAssessmentGuardian = $modelAssessmentGuardian;
        $this->modelAcademicAspect = $modelAcademicAspect;
        $this->modelAuditoryAspect = $modelAuditoryAspect;
        $this->modelBehavioralAspect = $modelBehavioralAspect;
        $this->modelCognitiveAspect = $modelCognitiveAspect;
        $this->modelMotorAspect = $modelMotorAspect;
        $this->modelVisualAspect = $modelVisualAspect;
        $this->modelSocialCommunicationAspect = $modelSocialCommunicationAspect;
    }

    public function createAssessmentGuardian(array $data)
    {
        return $this->modelAssessmentGuardian->create($data);
    }

    public function createAcademicAspect(array $data)
    {
        return $this->modelAcademicAspect->create($data);
    }

    public function createAuditoryImpairmentAspect(array $data)
    {
        return $this->modelAuditoryAspect->create($data);
    }

    public function createBehavioralImpairmentAspect(array $data)
    {
        return $this->modelBehavioralAspect->create($data);
    }

    public function createCognitiveImpairmentAspect(array $data)
    {
        return $this->modelCognitiveAspect->create($data);
    }

    public function createMotorImpairmentAspect(array $data)
    {
        return $this->modelMotorAspect->create($data);
    }

    public function createSocialCommunicationAspect(array $data)
    {
        return $this->modelSocialCommunicationAspect->create($data);
    }

    public function createVisualImpairmentAspect(array $data)
    {
        return $this->modelVisualAspect->create($data);
    }
}
