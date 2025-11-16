<?php

namespace App\Http\Controllers\Admin_Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\AssessmentScheduledDetailResource;
use App\Http\Resources\OccupationalTherapistDataAssessmentResource;
use App\Http\Resources\PedagogicalTherapistDataAssessmentResource;
use App\Http\Resources\PhysioTherapistDataAssessmentResource;
use App\Http\Resources\SpeechTherapistDataAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['type'] = $type;
        $user = $request->user();

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

    /*
     * Menampilkan jawaban asesmen terapis
     */
    public function showTherapistAssessmentAnswer(Request $request, Assessment $assessment): JsonResponse
    {
        // Validasi query parameter
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:fisio,wicara,okupasi,paedagog'],
        ]);

        $type = $validated['type'];
        $user = $request->user();

        if ($user->role !== 'asesor') {
            return $this->errorResponse(
                'Forbidden',
                ['error' => 'Hanya asesor yang memiliki izin untuk melihat jawaban asesmen'],
                403
            );
        }

        try {
            // Mengambil data berdasarkan tipe
            [$data, $message] = match ($type) {
                'fisio' => [
                    $this->assessmentService->getPhysioAssessmentTherapist($assessment),
                    'Data Fisio Asesmen Terapis'
                ],
                'wicara' => [
                    $this->assessmentService->getSpeechAssessmentTherapist($assessment),
                    'Data Wicara Asesmen Terapis'
                ],
                'okupasi' => [
                    $this->assessmentService->getOccuAssessmentTherapist($assessment),
                    'Data Okupasi Asesmen Terapis'
                ],
                'paedagog' => [
                    $this->assessmentService->getPedaAssessmentTherapist($assessment),
                    'Data Paedagog Asesmen Terapis'
                ],
            };

            $resource = $this->getTherapistResourceByType($type, $data);

            return $this->successResponse($resource, $message, 200);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), [], 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengambil data assessment', [], 500);
        }
    }

    public function showDetailScheduled(Request $request, AssessmentDetail $assessment): JsonResponse
    {
        $assessment->load(['assessment.child', 'assessment.child.family.guardians']);

        $response = new AssessmentScheduledDetailResource($assessment);

        return $this->successResponse($response, 'Detail Asesment Terjadwal', 200);
    }

    private function getTherapistResourceByType(string $type, $data)
    {
        return match ($type) {
            'fisio' => new PhysioTherapistDataAssessmentResource($data),
            'wicara' => new SpeechTherapistDataAssessmentResource($data),
            'okupasi' => new OccupationalTherapistDataAssessmentResource($data),
            'paedagog' => new PedagogicalTherapistDataAssessmentResource($data),
        };
    }
}
