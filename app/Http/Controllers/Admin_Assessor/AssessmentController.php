<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentsScheduledResource;
use App\Http\Resources\ObservationsScheduledResource;
use App\Http\Services\AssessmentService;
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
}
