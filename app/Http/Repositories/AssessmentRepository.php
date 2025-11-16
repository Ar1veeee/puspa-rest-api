<?php

namespace App\Http\Repositories;

use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AssessmentRepository
{
    protected $model;

    public function __construct(AssessmentDetail $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // mendapatkan data asesmen dengan filter by status, dan tipe
    public function getAssessmentWithFilter(array $filters = [])
    {
        $query = $this->model->query();

        $validTypes = ['fisio', 'okupasi', 'wicara', 'paedagog'];

        if (empty($filters['type']) || !in_array($filters['type'], $validTypes)) {
            return new Collection();
        }

        $query->where('type', $filters['type']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['scheduled_date'])) {
            $query->whereDate('scheduled_date', $filters['scheduled_date']);
        }

        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->whereHas('assessment.child', function ($childQuery) use ($searchTerm) {
                $childQuery->where('child_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        return $query
            ->with([
                'assessment.child' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'child_name',
                        'child_birth_date',
                        'child_gender'
                    );
                },
                'assessment.child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_phone'
                    );
                },
                'therapist:id,therapist_name',
                'admin:id,admin_name',
            ])
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function markAsComplete(int $assessment_id, string $type, $therapist_id)
    {
        return $this->model->where('assessment_id', $assessment_id)->where('type', $type)->update([
            'therapist_id' => $therapist_id,
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ]);
    }

    public function setScheduledDate(int $observation_id, string $date, $admin)
    {
        $assessment_id = Assessment::where('observation_id', $observation_id)->value('id');

        return $this->model->where('assessment_id', $assessment_id)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled',
            'admin_id' => $admin->id,
        ]);
    }

    public function updateScheduledDate(int $assessment_id, string $date, $admin)
    {
        return $this->model->where('assessment_id', $assessment_id)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled',
            'admin_id' => $admin->id,
        ]);
    }
}
