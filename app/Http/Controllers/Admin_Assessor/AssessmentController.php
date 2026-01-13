<?php

namespace App\Http\Controllers\Admin_Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentScheduledDetailResource;
use App\Models\Assessment;
use App\Services\AssessmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    public function __construct(
        AssessmentService $assessmentService
    )
    {
        $this->assessmentService = $assessmentService;
    }

    public function indexAnswersAssessment(Assessment $assessment, string $type)
    {
        $valid_types = [
            'paedagog_assessor',
            'wicara_assessor',
            'fisio_assessor',
            'okupasi_assessor',
            'umum_parent',
            'wicara_parent',
            'paedagog_parent',
            'okupasi_parent',
            'fisio_parent'
        ];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $response = $this->assessmentService->getAnswers($assessment, $type);

        $message = 'Riwayat Jawaban Asesmen ' . ucfirst($type);

        return $this->successResponse($response, $message, 200);
    }

    public function showDetailScheduled(Assessment $assessment): JsonResponse
    {
        $assessment->load([
            'assessmentDetails' => fn($query) => $query->with('admin'),
            'child',
            'child.family.guardians'
        ]);

        return $this->successResponse(
            new AssessmentScheduledDetailResource($assessment),
            'Detail Assessment Terjadwal',
            200
        );
    }

    public function uploadReportFile(Request $request, Assessment $assessment): JsonResponse
    {
        $this->validate($request, [
            'report-file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('report-file');

        $filename = Uuid::uuid4() . '.pdf';

        $path = $file->storeAs('assessment/reports', $filename, 'local');

        if (!$path) {
            return $this->errorResponse('File Upload Error', ['file' => ['Gagal mengunggah file laporan']], 500);
        }

        if ($assessment->report_file) {
            if (Storage::disk('local')->exists('assessment/reports/' . $assessment->report_file)) {
                Storage::disk('local')->delete('assessment/reports/' . $assessment->report_file);
            }
        }

        $assessment->update([
            'report_file' => $filename,
            'report_uploaded_at' => Carbon::now(),
        ]);

        $assessment->refresh();

        return $this->successResponse(
            null,
            'File laporan asesmen berhasil diunggah',
            200
        );
    }
}
