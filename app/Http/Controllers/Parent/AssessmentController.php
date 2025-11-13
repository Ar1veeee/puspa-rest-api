<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentGuardianRequest;
use App\Http\Requests\GuardianFamilyUpdateRequest;
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
use App\Http\Services\GuardianService;
use App\Models\Assessment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;
    protected $guardianService;


    public function __construct(
        AssessmentService $assessmentService,
        GuardianService $guardianService
    )
    {
        $this->assessmentService = $assessmentService;
        $this->guardianService = $guardianService;
    }

    public function indexChildrenAssessment(): JsonResponse
    {
        $userId = auth()->id();
        $childAssessment = $this->assessmentService->getChildrenAssessment($userId);
        return $this->successResponse(ChildrenAssessmentResource::collection($childAssessment), 'Daftar Assessment Semua Anak');
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

    public function updateFamilyData(GuardianFamilyUpdateRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
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
}
