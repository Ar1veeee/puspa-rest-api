<?php

namespace App\Http\Repositories;

use App\Models\Assessment;
use Illuminate\Support\Collection;

class AssessmentRepository
{
    protected $model;

    public function __construct(Assessment $model)
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

        $query->where($filters['type'], true);

        $query->where('status', $filters['status']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('scheduled_date', $filters['date']);
        }

        return $query
            ->with([
                'child' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'child_name',
                        'child_birth_date',
                        'child_gender'
                    );
                },
                'child.family.guardians' => function ($query) {
                    $query->select(
                        'id',
                        'family_id',
                        'guardian_name',
                        'guardian_phone'
                    );
                }
            ])
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByDate(array $filters = []): Collection
    {
        $query = $this->model->query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['scheduled_date'])) {
            $query->whereDate('scheduled_date', $filters['scheduled_date']);
        }

        $query->with([
            'child:id,family_id,child_name,child_gender,child_school,child_birth_date',
        ]);

        return $query->orderBy('scheduled_date', 'asc')->get();
    }

    public function setScheduledDate(int $observationId, string $date, $admin)
    {
        return $this->model->where('observation_id', $observationId)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled',
            'admin_id' => $admin->id,
        ]);
    }
}
