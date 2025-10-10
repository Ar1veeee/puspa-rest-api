<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\PhysioAssessmentGuardianRequest;
use App\Http\Services\PhysioAssessmentService;

class PhysioAssessmentController extends Controller
{
    use ResponseFormatter;

    protected $physioAssessmentService;

    public function __construct(PhysioAssessmentService $physioAssessmentService)
    {
        $this->physioAssessmentService = $physioAssessmentService;
    }

    public function storeAssessmentGuardian(PhysioAssessmentGuardianRequest $request, int $assessmentId)
    {
        $data = $request->validated();
        $this->physioAssessmentService->createAssessmentGuardian($assessmentId, $data);

        return $this->successResponse([], 'Assessment Fisio Berhasil Disimpan.', 201);
    }

}
