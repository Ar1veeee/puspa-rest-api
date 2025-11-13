<?php

namespace App\Http\Controllers\Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentTherapistRequest;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\OccupationalTherapistDataAssessmentResource;
use App\Http\Resources\PedagogicalTherapistDataAssessmentResource;
use App\Http\Resources\PhysioTherapistDataAssessmentResource;
use App\Http\Resources\SpeechTherapistDataAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function indexByStatus(Request $request, string $status): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:fisio,okupasi,wicara,paedagog'],
        ]);

        // Tipe terapis
        $type = $validated['type'];
        $user = $request->user();

        // Validasi apakah terapis tersebut adalah tipe terapis yang valid
        if ($user->role !== 'asesor') {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getChildrenAssessmentsByType($status, $type);

        $response = AssessmentListResource::collection($assessments);
        $message = 'Daftar Asesmen ' . ucfirst($type) . ' ' . ucfirst($status);
        return $this->successResponse($response, $message);
    }

    public function storeTherapistAssessment(AssessmentTherapistRequest $request, Assessment $assessment): JsonResponse
    {
        $data = $request->validated();
        $type = $data['type'];
        $user = $request->user();

        if ($user->role === 'asesor') {
            $section = $user->therapist->therapist_section;
            if ($section !== $type) {
                return $this->errorResponse(
                    'Forbidden',
                    ['error' => 'Anda hanya diizinkan untuk melakukan aksi pada asesmen ' . $section],
                    403
                );
            }
        }

        $method = match ($type) {
            'fisio' => 'createPhysioAssessmentTherapist',
            'okupasi' => 'createOccuAssessmentTherapist',
            'wicara' => 'createSpeechAssessmentTherapist',
            'paedagog' => 'createPedaAssessmentTherapist',
            default => null,
        };

        if (!$method) {
            return $this->errorResponse('Bad Request', ['error' => 'Invalid assessment type'], 400);
        }

        $this->assessmentService->$method($assessment, $data);

        $message = sprintf('Assessment %s Berhasil Disimpan', ucfirst($type));

        return $this->successResponse([], $message, 201);
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
