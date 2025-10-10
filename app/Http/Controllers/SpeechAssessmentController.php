<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\SpeechAssessmentGuardianRequest;
use App\Http\Services\SpeechAssessmentService;

class SpeechAssessmentController extends Controller
{
    use ResponseFormatter;

    protected $speechAssessmentService;

    public function __construct(SpeechAssessmentService $speechAssessmentService)
    {
        $this->speechAssessmentService = $speechAssessmentService;
    }

    public function storeAssessmentGuardian(SpeechAssessmentGuardianRequest $request, int $assessmentId)
    {
        $data = $request->validated();
        $this->speechAssessmentService->createAssessmentGuardian($assessmentId, $data);

        return $this->successResponse([], 'Assessment Wicara Berhasil Disimpan.', 201);
    }
}
