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
use Illuminate\Support\Facades\Auth;
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

    public function getAssessmentsScheduled(array $filters = [])
    {
        $status = 'scheduled';

        $queryFilters = [
            'status' => $status,
        ];

        // Jika ada tanggal, tambahkan
        if (!empty($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        return $this->assessmentRepository->getByDate($queryFilters);
    }

    public function getChildrenAssessmentsByType(string $status, $type)
    {
        return $this->assessmentRepository->getByScheduledType($status, $type);
    }

    // Data umum di pertanyaan ortu
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
        $physioData = $assessment->physioAssessmentGuardian()->first();
        if (!$physioData) {
            throw new ModelNotFoundException('Data assessment fisio tidak ditemukan.');
        }

        return $physioData;
    }

    public function getSpeechGuardian(Assessment $assessment)
    {
        $speechData = $assessment->speechAssessmentGuardian()->first();
        if (!$speechData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $speechData;
    }

    public function getOccupationalGuardian(Assessment $assessment)
    {
        $assessment->load([
            'occupationalAssessmentGuardian' => function ($query) {
                $query->with([
                    'auditoryCommunication',
                    'sensoryModalityTest',
                    'sensoryProcessingScreening',
                    'adlMotorSkill',
                    'behaviorSocial',
                    'behaviorScale',
                ]);
            },
        ]);

        $occupationalData = $assessment->occupationalAssessmentGuardian;

        if (!$occupationalData) {
            throw new ModelNotFoundException('Data assessment okupasi tidak ditemukan.');
        }

        return $occupationalData;
    }

    public function getPedagogicalGuardian(Assessment $assessment)
    {
        $assessment->load([
            'pedagogicalAssessmentGuardian' => function ($query) {
                $query->with([
                    'academicAspect',
                    'visualImpairmentAspect',
                    'auditoryImpairmentAspect',
                    'cognitiveImpairmentAspect',
                    'motorImpairmentAspect',
                    'behavioralImpairmentAspect',
                    'socialCommunicationAspect',
                ]);
            },
        ]);

        $pedagogicalData = $assessment->pedagogicalAssessmentGuardian;

        if (!$pedagogicalData) {
            throw new ModelNotFoundException('Data assessment okupasi tidak ditemukan.');
        }

        return $pedagogicalData;
    }

    // Assessment sisi terapis
    public function getPhysioAssessmentTherapist(Assessment $assessment)
    {
        $assessment->load([
            'physioAssessmentTherapist' => function ($query) {
                $query->with([
                    'therapist',
                    'generalExamination',
                    'systemAnamnesis',
                    'sensoryExamination',
                    'reflexExamination',
                    'muscleStrengthExamination',
                    'spasticityExamination',
                    'jointLaxityTest',
                    'grossMotorExamination',
                    'musclePalpation',
                    'spasticityType',
                    'playFunctionTest',
                    'physiotherapyDiagnosis',
                ]);
            },
        ]);

        $physioData = $assessment->physioAssessmentTherapist;

        if (!$physioData) {
            throw new ModelNotFoundException('Data assessment fisio tidak ditemukan.');
        }

        return $physioData;
    }

    public function getPedaAssessmentTherapist(Assessment $assessment)
    {
        $assessment->load([
            'pedaAssessmentTherapist' => function ($query) {
                $query->with([
                    'therapist',
                    'readingAspect',
                    'writingAspect',
                    'countingAspect',
                    'learningReadinessAspect',
                    'generalKnowledgeAspect',
                ]);
            },
        ]);

        $pedaData = $assessment->pedaAssessmentTherapist;

        if (!$pedaData) {
            throw new ModelNotFoundException('Data assessment paedagogical tidak ditemukan.');
        }

        return $pedaData;
    }

    public function getSpeechAssessmentTherapist(Assessment $assessment)
    {
        $assessment->load([
            'speechAssessmentTherapist' => function ($query) {
                $query->with([
                    'therapist',
                    'oralFacialAspect',
                    'languageSkillAspect',
                ]);
            },
        ]);

        $speechData = $assessment->speechAssessmentTherapist;

        if (!$speechData) {
            throw new ModelNotFoundException('Data assessment wicara tidak ditemukan.');
        }

        return $speechData;
    }

    public function getOccuAssessmentTherapist(Assessment $assessment)
    {
        $assessment->load([
            'occuAssessmentTherapist' => function ($query) {
                $query->with([
                    'therapist',
                    'bodilySelfSense',
                    'balanceCoordination',
                    'concentrationProblemSolving',
                    'conceptKnowledge',
                    'motoricPlanning',
                ]);
            },
        ]);

        $occuData = $assessment->occuAssessmentTherapist;

        if (!$occuData) {
            throw new ModelNotFoundException('Data assessment okupasi tidak ditemukan.');
        }

        return $occuData;
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

    public function createPhysioAssessmentGuardian(Assessment $assessment, array $data)
    {
        if (!$assessment->fisio) {
            throw new ModelNotFoundException('Penilaian fisio tidak diaktifkan untuk asesmen ini.');
        }

        return $this->physioAssessmentRepository->createAssessmentGuardian(
            array_merge($data, [
                'assessment_id' => $assessment->id,
            ])
        );
    }

    // Soft calling
    public function createPhysioAssessmentTherapist(Assessment $assessment, array $data)
    {
        $therapist = $this->getAuthenticatedTherapist();

        if (!$assessment->fisio) {
            throw new ModelNotFoundException('Penilaian fisio tidak diaktifkan untuk asesmen ini.');
        }

        return DB::transaction(function () use ($assessment, $therapist, $data) {
            $general = $this->physioAssessmentRepository->createGeneralExamination($data);
            $systemAnamnesis = $this->physioAssessmentRepository->createSystemAnamnesis($data);
            $sensory = $this->physioAssessmentRepository->createSensoryExamination($data);
            $reflex = $this->physioAssessmentRepository->createReflexExamination($data);
            $spasticityExam = $this->physioAssessmentRepository->createSpasticityExamination($data);
            $muscleStrength = $this->physioAssessmentRepository->createMuscleStrengthExamination($data);
            $jointLaxity = $this->physioAssessmentRepository->createJointLaxityTest($data);
            $grossMotor = $this->physioAssessmentRepository->createGrossMotorExamination($data);
            $musclePalpation = $this->physioAssessmentRepository->createMusclePalpation($data);
            $spasticityType = $this->physioAssessmentRepository->createSpasticityType($data);
            $playFunction = $this->physioAssessmentRepository->createPlayFunctionTest($data);
            $diagnosis = $this->physioAssessmentRepository->createPhysiotherapyDiagnosis($data);

            return $this->physioAssessmentRepository->createAssessmentTherapist([
                'assessment_id' => $assessment->id,
                'therapist_id' => $therapist->id,
                'general_examination_id' => $general->id,
                'system_anamnesis_id' => $systemAnamnesis->id,
                'sensory_examination_id' => $sensory->id,
                'reflex_examination_id' => $reflex->id,
                'muscle_strength_examination_id' => $muscleStrength->id,
                'spasticity_examination_id' => $spasticityExam->id,
                'joint_laxity_test_id' => $jointLaxity->id,
                'gross_motor_examination_id' => $grossMotor->id,
                'muscle_palpation_id' => $musclePalpation->id,
                'spasticity_type_id' => $spasticityType->id,
                'play_function_test_id' => $playFunction->id,
                'physiotherapy_diagnosis_id' => $diagnosis->id,
            ]);
        });
    }

    public function createOccuAssessmentGuardian(Assessment $assessment, array $data)
    {
        if (!$assessment->okupasi) {
            throw new ModelNotFoundException('Penilaian okupasi tidak diaktifkan untuk asesmen ini.');
        }

        return DB::transaction(function () use ($assessment, $data) {
            $auditory = $this->occupationalAssessmentRepository->createAuditoryCommunication($data);
            $sensoryModality = $this->occupationalAssessmentRepository->createSensoryModality($data);
            $sensoryProcessing = $this->occupationalAssessmentRepository->createSensoryProcessing($data);
            $adlMotor = $this->occupationalAssessmentRepository->createAdlMotorSkill($data);
            $behaviorSocial = $this->occupationalAssessmentRepository->createBehaviorSocial($data);
            $behaviorScale = $this->occupationalAssessmentRepository->createBehaviorScale($data);

            return $this->occupationalAssessmentRepository->createAssessmentGuardian([
                'assessment_id' => $assessment->id,
                'auditory_communication_id' => $auditory->id,
                'sensory_modality_id' => $sensoryModality->id,
                'sensory_processing_screening_id' => $sensoryProcessing->id,
                'adl_motor_skill_id' => $adlMotor->id,
                'behavior_social_id' => $behaviorSocial->id,
                'behavior_scale_id' => $behaviorScale->id,
            ]);
        });
    }

    // Soft calling
    public function createOccuAssessmentTherapist(Assessment $assessment, array $data)
    {
        $therapist = $this->getAuthenticatedTherapist();

        if (!$assessment->okupasi) {
            throw new ModelNotFoundException('Penilaian okupasi tidak diaktifkan untuk asesmen ini.');
        }

        return DB::transaction(function () use ($assessment, $therapist, $data) {
            $balance = $this->occupationalAssessmentRepository->createBalanceCoordination($data);
            $bodily = $this->occupationalAssessmentRepository->createBodilySelfSense($data);
            $concentration = $this->occupationalAssessmentRepository->createConcentrationProblemSolving($data);
            $knowledge = $this->occupationalAssessmentRepository->createConceptKnowledge($data);
            $motoric = $this->occupationalAssessmentRepository->createMotoricPlanning($data);

            return $this->occupationalAssessmentRepository->createAssessmentTherapist(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                    'therapist_id' => $therapist->id,
                    'bodily_self_sense_id' => $balance->id,
                    'balance_coordination_id' => $bodily->id,
                    'concentration_problem_solving_id' => $concentration->id,
                    'concept_knowledge_id' => $knowledge->id,
                    'motoric_planning_id' => $motoric->id,
                ])
            );
        });
    }

    public function createSpeechAssessmentGuardian(Assessment $assessment, array $data)
    {
        if (!$assessment->wicara) {
            throw new ModelNotFoundException('Penilaian wicara tidak diaktifkan untuk asesmen ini.');
        }

        return $this->speechAssessmentRepository->createAssessmentGuardian(
            array_merge($data, [
                'assessment_id' => $assessment->id,
            ])
        );
    }

    // Soft calling
    public function createSpeechAssessmentTherapist(Assessment $assessment, array $data)
    {
        if (!$assessment->wicara) {
            throw new ModelNotFoundException('Penilaian wicara tidak diaktifkan untuk asesmen ini.');
        }

        $therapist = $this->getAuthenticatedTherapist();

        return DB::transaction(function () use ($assessment, $therapist, $data) {
            $oralFacial = $this->speechAssessmentRepository->createOralFacial($data);
            $languageSkill = $this->speechAssessmentRepository->createLanguageSkill($data);

            return $this->speechAssessmentRepository->createAssessmentTherapist([
                'assessment_id' => $assessment->id,
                'therapist_id' => $therapist->id,
                'oral_facial_aspect_id' => $oralFacial->id,
                'language_skill_aspect_id' => $languageSkill->id,
            ]);
        });
    }

    public function createPedaAssessmentGuardian(Assessment $assessment, array $data)
    {
        if (!$assessment->paedagog) {
            throw new ModelNotFoundException('Penilaian paedagog tidak diaktifkan untuk asesmen ini.');
        }

        return DB::transaction(function () use ($assessment, $data) {
            $academic = $this->pedagogicalAssessmentRepository->createAcademicAspect($data);
            $auditory = $this->pedagogicalAssessmentRepository->createAuditoryImpairmentAspect($data);
            $behavioral = $this->pedagogicalAssessmentRepository->createBehavioralImpairmentAspect($data);
            $cognitive = $this->pedagogicalAssessmentRepository->createCognitiveImpairmentAspect($data);
            $motor = $this->pedagogicalAssessmentRepository->createMotorImpairmentAspect($data);
            $socialCommunication = $this->pedagogicalAssessmentRepository->createSocialCommunicationAspect($data);
            $visual = $this->pedagogicalAssessmentRepository->createVisualImpairmentAspect($data);

            return $this->pedagogicalAssessmentRepository->createAssessmentGuardian([
                'assessment_id' => $assessment->id,
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

    // Soft calling
    public function createPedaAssessmentTherapist(Assessment $assessment, array $data)
    {
        if (!$assessment->paedagog) {
            throw new ModelNotFoundException('Penilaian paedagog tidak diaktifkan untuk asesmen ini.');
        }

        $therapist = $this->getAuthenticatedTherapist();

        return DB::transaction(function () use ($assessment, $therapist, $data) {
            $reading = $this->pedagogicalAssessmentRepository->createReadingAspect($data);
            $writing = $this->pedagogicalAssessmentRepository->createWritingAspect($data);
            $counting = $this->pedagogicalAssessmentRepository->createCountingAspect($data);
            $learningReadiness = $this->pedagogicalAssessmentRepository->createLearningReadinessAspect($data);
            $generalKnowledge = $this->pedagogicalAssessmentRepository->createGeneralKnowledgeAspect($data);

            return $this->pedagogicalAssessmentRepository->createAssessmentTherapist(
                array_merge($data, [
                    'assessment_id' => $assessment->id,
                    'therapist_id' => $therapist->id,
                    'reading_aspect_id' => $reading->id,
                    'writing_aspect_id' => $writing->id,
                    'counting_aspect_id' => $counting->id,
                    'learning_readiness_aspect_id' => $learningReadiness->id,
                    'general_knowledge_aspect_id' => $generalKnowledge->id,
                ])
            );
        });
    }

    private function getAuthenticatedTherapist()
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Tidak ada pengguna yang terautentikasi.');
        }

        $therapist = $user->therapist;

        if (!$therapist) {
            throw new \Exception('Profil terapis tidak ditemukan untuk pengguna ini.');
        }

        return $therapist;
    }
}
