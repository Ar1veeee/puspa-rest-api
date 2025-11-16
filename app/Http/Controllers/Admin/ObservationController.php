<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentUpdateRequest;
use App\Http\Requests\ObservationUpdateRequest;
use App\Http\Resources\ObservationsScheduledResource;
use App\Http\Services\ObservationService;
use App\Models\Observation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    use ResponseFormatter;

    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    public function updateObservationDate(ObservationUpdateRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->updateObservationDate($data, $observation);

        return $this->successResponse([], 'Jadwal Observasi Berhasil Diperbarui', 200);
    }

    /**
     * @throws \Exception
     */
    public function assessmentAgreement(AssessmentUpdateRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->assessmentAgreement($data, $observation);

        return $this->successResponse([], 'Assessment Berhasil Diperbarui', 200);
    }
}
