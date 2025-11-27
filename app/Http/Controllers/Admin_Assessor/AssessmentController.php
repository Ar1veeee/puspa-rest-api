<?php

namespace App\Http\Controllers\Admin_Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\AssessmentScheduledDetailResource;
use App\Http\Resources\OccupationalTherapistDataAssessmentResource;
use App\Http\Resources\PedagogicalTherapistDataAssessmentResource;
use App\Http\Resources\PhysioTherapistDataAssessmentResource;
use App\Http\Resources\SpeechTherapistDataAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;


    public function __construct(
        AssessmentService $assessmentService,
    )
    {
        $this->assessmentService = $assessmentService;
    }

    public function indexAnswersAssessment(Assessment $assessment, string $type)
    {
        $valid_types = [
            'paedagog_assessor',
            'wicara_assessor',
            'fisio_assessor',
            'okupasi_assessor',
            'umum_parent',
            'wicara_parent',
            'paedagog_parent',
            'okupasi_parent',
            'fisio_parent'
        ];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $response = $this->assessmentService->getAnswers($assessment, $type);

        $message = 'Riwayat Jawaban Asesmen ' . ucfirst($type);

        return $this->successResponse($response, $message, 200);
    }

    public function showDetailScheduled(Request $request, AssessmentDetail $assessment): JsonResponse
    {
        $assessment->load(['assessment.child', 'assessment.child.family.guardians']);

        $response = new AssessmentScheduledDetailResource($assessment);

        return $this->successResponse($response, 'Detail Asesment Terjadwal', 200);
    }
}
