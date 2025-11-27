<?php

namespace App\Http\Repositories;

use App\Models\AssessmentDetail;
use Illuminate\Support\Collection;

class AssessmentDetailRepository
{
    protected $model;
    private $assessmentRepository;

    public function __construct(
        AssessmentDetail     $model,
        AssessmentRepository $assessmentRepository
    )
    {
        $this->model = $model;
        $this->assessmentRepository = $assessmentRepository;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getParentsAssessmentWithFilter(array $filters)
    {
        $query = $this->model->query();

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
            ->where('parent_completed_status', $filters['parent_completed_status'])
            ->get();
    }

    // mendapatkan data asesmen berdasarkan tipe dengan filter status, tanggal dan pencarian
    public function getAssessmentByStatusWithFilter(array $filters = [])
    {
        $query = $this->model->query();

        $valid_status = ['scheduled', 'completed'];

        if (empty($filters['status']) || !in_array($filters['status'], $valid_status)) {
            return new Collection();
        }

        $query->where('status', $filters['status']);

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
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

    public function setScheduledDate(int $observation_id, string $date, $admin)
    {
        $assessment_id = $this->assessmentRepository->getIdByObservationId($observation_id);

        if ($assessment_id) {
            return $this->updateScheduledDate($assessment_id, $date, $admin);
        }

        return 0;
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
