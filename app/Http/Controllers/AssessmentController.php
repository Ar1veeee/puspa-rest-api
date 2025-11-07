<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentGuardianRequest;
use App\Http\Requests\AssessmentTherapistRequest;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Http\Resources\GeneralDataAssessmentResource;
use App\Http\Resources\OccupationalGuardianDataAssessmentResource;
use App\Http\Resources\OccupationalTherapistDataAssessmentResource;
use App\Http\Resources\PedagogicalGuardianDataAssessmentResource;
use App\Http\Resources\PedagogicalTherapistDataAssessmentResource;
use App\Http\Resources\PhysioGuardianDataAssessmentResource;
use App\Http\Resources\PhysioTherapistDataAssessmentResource;
use App\Http\Resources\SpeechGuardianDataAssessmentResource;
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

    public function indexChildrenAssessment(): JsonResponse
    {
        $userId = auth()->id();
        $childAssessment = $this->assessmentService->getChildrenAssessment($userId);
        return $this->successResponse(ChildrenAssessmentResource::collection($childAssessment), 'Daftar Assessment Semua Anak');
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

    public function storeGuardianAssessment(AssessmentGuardianRequest $request, Assessment $assessment): JsonResponse
    {
        $type = $request->input('type');

        try {
            // Menyimpan data berdasarkan tipe
            $result = match ($type) {
                'umum' => $this->assessmentService->createGeneralData($assessment, $request->validated()),
                'fisio' => $this->assessmentService->createPhysioAssessmentGuardian($assessment, $request->validated()),
                'wicara' => $this->assessmentService->createSpeechAssessmentGuardian($assessment, $request->validated()),
                'okupasi' => $this->assessmentService->createOccuAssessmentGuardian($assessment, $request->validated()),
                'paedagog' => $this->assessmentService->createPedaAssessmentGuardian($assessment, $request->validated()),
            };

            $message = match ($type) {
                'umum' => 'Data umum berhasil disimpan',
                'fisio' => 'Data fisio berhasil disimpan',
                'wicara' => 'Data wicara berhasil disimpan',
                'okupasi' => 'Data okupasi berhasil disimpan',
                'paedagog' => 'Data paedagog berhasil disimpan',
            };

            return $this->successResponse($result, $message, 201);

        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menyimpan data assessment', [], 500);
        }
    }

    public function storeTherapistAssessment(AssessmentTherapistRequest $request, Assessment $assessment): JsonResponse
    {
        $data = $request->validated();
        $type = $data['type'];
        $user = $request->user();

        if ($user->role === 'terapis') {
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

    // Menampilkan jadwal asesmen semua anak yang dimiliki orang tua
    public function show(Assessment $assessment)
    {
        $this->authorize('view', $assessment);
        return $this->successResponse(new AssessmentsDetailResource($assessment), 'Detail Assessment Untuk Anak');
    }

    /*
     * Menampilkan jawaban asesmen pertanyaan ortu
     */
    public function showGuardianAssessmentAnswer(Request $request, Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);

        // Validasi query parameter
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:umum,fisio,wicara,okupasi,paedagog'],
        ]);

        $type = $validated['type'];

        try {
            // Mengambil data berdasarkan tipe
            [$data, $message] = match ($type) {
                'umum' => [
                    $this->assessmentService->getGeneral($assessment),
                    'Data Umum Asesmen Pertanyaan'
                ],
                'fisio' => [
                    $this->assessmentService->getPhysioGuardian($assessment),
                    'Data Fisio Asesmen Pertanyaan'
                ],
                'wicara' => [
                    $this->assessmentService->getSpeechGuardian($assessment),
                    'Data Wicara Asesmen Pertanyaan'
                ],
                'okupasi' => [
                    $this->assessmentService->getOccupationalGuardian($assessment),
                    'Data Okupasi Asesmen Pertanyaan'
                ],
                'paedagog' => [
                    $this->assessmentService->getPedagogicalGuardian($assessment),
                    'Data Paedagog Asesmen Pertanyaan'
                ],
            };

            $resource = $this->getGuardianResourceByType($type, $data);

            return $this->successResponse($resource, $message, 200);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), [], 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengambil data assessment', [], 500);
        }
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

    private function getGuardianResourceByType(string $type, $data)
    {
        return match ($type) {
            'umum' => new GeneralDataAssessmentResource($data),
            'fisio' => new PhysioGuardianDataAssessmentResource($data),
            'wicara' => new SpeechGuardianDataAssessmentResource($data),
            'okupasi' => new OccupationalGuardianDataAssessmentResource($data),
            'paedagog' => new PedagogicalGuardianDataAssessmentResource($data),
        };
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
