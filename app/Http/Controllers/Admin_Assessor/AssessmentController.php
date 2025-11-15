<?php

namespace App\Http\Controllers\Admin_Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentListResource;
use App\Http\Services\AssessmentService;
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

    // Menampilkan asesmen terdaftar berdasarkan status (terjadwal, selesai) dan tipe (fisio, wicara, dll)
    public function indexAssessmentsByType(Request $request, string $type): JsonResponse
    {
        $validTypes = ['fisio', 'okupasi', 'wicara', 'paedagog'];
        if (!in_array($type, $validTypes)) {
            return $this->errorResponse('Validation Error', ['type' => ['Jenis asesmen tidak valid']], 422);
        }

        $validated = $request->validate([
            'status' => ['nullable', 'string', 'in:scheduled,completed'],
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
        ]);

        // Tipe terapis
        $validated['type'] = $type;
        $user = $request->user();

        // Validasi terapis tidak dapat mengakses asesmen
        if ($user->role === 'terapis') {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getAssessmentsByType($validated);

        $response = AssessmentListResource::collection($assessments);
        $message = 'Daftar Asesmen ' . ucfirst($type);
        if (isset($validated['status'])) {
            $message .= ' ' . ucfirst($validated['status']);
        }
        return $this->successResponse($response, $message);
    }
}
