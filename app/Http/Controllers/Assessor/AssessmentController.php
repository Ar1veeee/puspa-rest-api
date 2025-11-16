<?php

namespace App\Http\Controllers\Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentTherapistRequest;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;

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

    public function storeTherapistAssessment(AssessmentTherapistRequest $request, Assessment $assessment): JsonResponse
    {
        $data = $request->validated();
        $type = $data['type'];
        $user = $request->user();

        if ($user->role === 'asesor') {
            $section = $user->therapist->therapist_section;
            if ($section !== $type) {
                return $this->errorResponse(
                    'Forbidden',
                    ['error' => 'Anda hanya diizinkan untuk melakukan aksi pada asesmen ' . $section],
                    403
                );
            }
        }

        $method = match ($type) {
            'fisio' => 'createPhysioAssessmentTherapist',
            'okupasi' => 'createOccuAssessmentTherapist',
            'wicara' => 'createSpeechAssessmentTherapist',
            'paedagog' => 'createPedaAssessmentTherapist',
            default => null,
        };

        if (!$method) {
            return $this->errorResponse('Bad Request', ['error' => 'Invalid assessment type'], 400);
        }

        $this->assessmentService->$method($assessment, $data);

        $message = sprintf('Assessment %s Berhasil Disimpan', ucfirst($type));

        return $this->successResponse([], $message, 201);
    }
}
