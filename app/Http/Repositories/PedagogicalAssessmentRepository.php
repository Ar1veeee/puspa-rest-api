<?php

namespace App\Http\Repositories;

use App\Models\PedaAssessmentTherapist;
use App\Models\PedaCountingAspect;
use App\Models\PedaGeneralKnowledgeAspect;
use App\Models\PedagogicalAcademicAspect;
use App\Models\PedagogicalAssessmentGuardian;
use App\Models\PedagogicalAuditoryImpairmentAspect;
use App\Models\PedagogicalBehavioralImpairmentAspect;
use App\Models\PedagogicalCognitiveImpairmentAspect;
use App\Models\PedagogicalMotorImpairmentAspect;
use App\Models\PedagogicalSocialCommunicationAspect;
use App\Models\PedagogicalVisualImpairmentAspect;
use App\Models\PedaLearningReadinessAspect;
use App\Models\PedaReadingAspect;
use App\Models\PedaWritingAspect;

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

    protected $modelAssessmentTherapist;
    protected $modelReadingAspect;
    protected $modelWritingAspect;
    protected $modelCountingAspect;
    protected $modelLearningReadinessAspect;
    protected $modelGeneralKnowledgeAspect;

    public function __construct(
        PedagogicalAssessmentGuardian         $modelAssessmentGuardian,
        PedagogicalAcademicAspect             $modelAcademicAspect,
        PedagogicalAuditoryImpairmentAspect   $modelAuditoryAspect,
        PedagogicalBehavioralImpairmentAspect $modelBehavioralAspect,
        PedagogicalCognitiveImpairmentAspect  $modelCognitiveAspect,
        PedagogicalMotorImpairmentAspect      $modelMotorAspect,
        PedagogicalVisualImpairmentAspect     $modelVisualAspect,
        PedagogicalSocialCommunicationAspect  $modelSocialCommunicationAspect,

        PedaAssessmentTherapist $modelAssessmentTherapist,
        PedaReadingAspect $modelReadingAspect,
        PedaWritingAspect $modelWritingAspect,
        PedaCountingAspect $modelCountingAspect,
        PedaLearningReadinessAspect $modelLearningReadinessAspect,
        PedaGeneralKnowledgeAspect $modelGeneralKnowledgeAspect,
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
        $this->modelAssessmentTherapist = $modelAssessmentTherapist;
        $this->modelReadingAspect = $modelReadingAspect;
        $this->modelWritingAspect = $modelWritingAspect;
        $this->modelCountingAspect = $modelCountingAspect;
        $this->modelLearningReadinessAspect = $modelLearningReadinessAspect;
        $this->modelGeneralKnowledgeAspect = $modelGeneralKnowledgeAspect;
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

    public function createAssessmentTherapist(array $data)
    {
        return $this->modelAssessmentTherapist->create($data);
    }

    public function createReadingAspect(array $data)
    {
        return $this->modelReadingAspect->create($data);
    }

    public function createWritingAspect(array $data)
    {
        return $this->modelWritingAspect->create($data);
    }

    public function createCountingAspect(array $data)
    {
        return $this->modelCountingAspect->create($data);
    }

    public function createLearningReadinessAspect(array $data)
    {
        return $this->modelLearningReadinessAspect->create($data);
    }

    public function createGeneralKnowledgeAspect(array $data)
    {
        return $this->modelGeneralKnowledgeAspect->create($data);
    }
}
