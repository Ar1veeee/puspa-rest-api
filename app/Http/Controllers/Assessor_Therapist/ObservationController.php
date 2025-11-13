<?php

namespace App\Http\Controllers\Assessor_Therapist;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ObservationSubmitRequest;
use App\Http\Services\ObservationService;
use App\Models\Observation;
use Illuminate\Http\JsonResponse;

class ObservationController extends Controller
{
    use ResponseFormatter;

    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    public function submit(ObservationSubmitRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->submitObservation($data, $observation);

        return $this->successResponse([], 'Observasi Berhasil Disimpan', 200);
    }
}
