<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\PedagogicalAssessmentGuardianRequest;
use App\Http\Services\PedagogicalAssessmentService;

class PedagogicalAssessmentController extends Controller
{
    use ResponseFormatter;

    protected $pedagogicalAssessmentService;

    public function __construct(PedagogicalAssessmentService $pedagogicalAssessmentService)
    {
        $this->pedagogicalAssessmentService = $pedagogicalAssessmentService;
    }

    public function storeAssessmentGuardian(PedagogicalAssessmentGuardianRequest $request, int $assessmentId)
    {
        $data = $request->validated();
        $this->pedagogicalAssessmentService->createAssessmentGuardian($assessmentId, $data);

        return $this->successResponse([], 'Assessment Paedagog Berhasil Disimpan');
    }
}
