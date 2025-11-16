<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentUpdateRequest;
use App\Http\Services\AssessmentService;
use App\Models\AssessmentDetail;
use App\Models\Observation;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function updateAssessmentDate(AssessmentUpdateRequest $request, AssessmentDetail $assessment): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->updateScheduledDate($data, $assessment);

        return $this->successResponse([], 'Jadwal Assessment Berhasil Diperbarui', 200);
    }
}
