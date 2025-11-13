<?php

namespace App\Http\Controllers\Admin_Assessor_Therapist;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\ObservationCompletedDetailResource;
use App\Http\Resources\ObservationDetailAnswerResource;
use App\Http\Resources\ObservationQuestionsResource;
use App\Http\Resources\ObservationScheduledDetailResource;
use App\Http\Resources\ObservationsCompletedResource;
use App\Http\Resources\ObservationsPendingResource;
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

    public function indexByStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['nullable', 'string', 'in:pending,scheduled,completed'],
        ]);

        $observations = $this->observationService->getObservations($validated);
        $status = $validated['status'] ?? 'all';

        $resourceCollection = match ($status) {
            'pending' => ObservationsPendingResource::collection($observations),
            'scheduled' => ObservationsScheduledResource::collection($observations),
            'completed' => ObservationsCompletedResource::collection($observations),
            default => null,
        };

        $message = 'Daftar Observasi ' . ucfirst($status);

        return $this->successResponse($resourceCollection, $message, 200);
    }

    public function showByType(Request $request, Observation $observation): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:scheduled,completed,question,answer'],
        ]);

        $type = $validated['type'];

        if (in_array($type, ['scheduled', 'completed'])) {
            $observation->load(['child', 'child.family.guardians']);
        } elseif ($type === 'answer') {
            $observation->load('observation_answers.observation_question');
        }

        [$response, $message] = match ($type) {
            'scheduled' => [
                new ObservationScheduledDetailResource($observation),
                'Observasi Scheduled Detail'
            ],
            'completed' => [
                new ObservationCompletedDetailResource($observation),
                'Observasi Completed Detail'
            ],
            'question' => [
                ObservationQuestionsResource::collection(
                    $this->observationService->getObservationQuestions($observation)
                ),
                'Pertanyaan Observasi'
            ],
            'answer' => [
                new ObservationDetailAnswerResource($observation),
                'Observasi Detail Answer'
            ],
        };

        return $this->successResponse($response, $message, 200);
    }
}
