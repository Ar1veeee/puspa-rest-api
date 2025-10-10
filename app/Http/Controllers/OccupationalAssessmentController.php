<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\OccupationalAssessmentGuardianRequest;
use App\Http\Services\OccupationalAssessmentService;

class OccupationalAssessmentController extends Controller
{
    use ResponseFormatter;

    protected $occupationalAssessmentService;

    public function __construct(OccupationalAssessmentService $occupationalAssessmentService)
    {
        $this->occupationalAssessmentService = $occupationalAssessmentService;
    }

    public function storeAssessmentGuardian(OccupationalAssessmentGuardianRequest $request, int $assessmentId)
    {
        $data = $request->validated();
        $this->occupationalAssessmentService->createAssessmentGuardian($assessmentId, $data);

        return $this->successResponse([], 'Assessment Okupasi Berhasil Disimpan');
    }
}
