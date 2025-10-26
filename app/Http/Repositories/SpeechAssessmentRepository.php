<?php

namespace App\Http\Repositories;

use App\Models\SpeechAssessmentGuardian;
use App\Models\SpeechAssessmentTherapist;
use App\Models\SpeechLanguageSkillAspect;
use App\Models\SpeechOralFacialAspect;

class SpeechAssessmentRepository
{
    protected $modelSpeechAssessmentGuardian;
    protected $modelSpeechAssessmentTherapist;
    protected $modelOralFacialAspect;
    protected $modelLanguageSkillAspect;

    public function __construct(
        SpeechAssessmentGuardian  $modelSpeechAssessmentGuardian,
        SpeechAssessmentTherapist $modelSpeechAssessmentTherapist,
        SpeechOralFacialAspect    $modelOralFacialAspect,
        SpeechLanguageSkillAspect $modelLanguageSkillAspect,
    )
    {
        $this->modelSpeechAssessmentGuardian = $modelSpeechAssessmentGuardian;
        $this->modelSpeechAssessmentTherapist = $modelSpeechAssessmentTherapist;
        $this->modelOralFacialAspect = $modelOralFacialAspect;
        $this->modelLanguageSkillAspect = $modelLanguageSkillAspect;
    }

    public function createAssessmentGuardian(array $data)
    {
        return $this->modelSpeechAssessmentGuardian->create($data);
    }

    public function createAssessmentTherapist(array $data)
    {
        return $this->modelSpeechAssessmentTherapist->create($data);
    }

    public function createOralFacial(array $data)
    {
        return $this->modelOralFacialAspect->create($data);
    }

    public function createLanguageSkill(array $data)
    {
        return $this->modelLanguageSkillAspect->create($data);
    }
}
