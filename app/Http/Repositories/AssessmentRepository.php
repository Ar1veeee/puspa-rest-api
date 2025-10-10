<?php

namespace App\Http\Repositories;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function getParentDataById(int $id)
    {
        $assessment = $this->model->find($id);

        if (!$assessment) {
            throw new ModelNotFoundException('Assessment dengan ID ' . $id . ' tidak ditemukan.');
        }

        return $assessment->load([
            'child.family.guardians' => function ($query) {
                $query->select(
                    'id',
                    'family_id',
                    'guardian_type',
                    'guardian_name',
                    'guardian_birth_date',
                    'guardian_occupation',
                    'guardian_phone',
                    'relationship_with_child'
                );
            }
        ]);
    }

    public function getByScheduledPhysio()
    {
        return $this->model
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
                        'guardian_phone',
                    );
                }
            ])
            ->where('status', 'scheduled')
            ->where('fisio', true)
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByScheduledOccupation()
    {
        return $this->model
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
                        'guardian_phone',
                    );
                }
            ])
            ->where('status', 'scheduled')
            ->where('okupasi', true)
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByScheduledSpeech()
    {
        return $this->model
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
                        'guardian_phone',
                    );
                }
            ])
            ->where('status', 'scheduled')
            ->where('wicara', true)
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getByScheduledPedagogical()
    {
        return $this->model
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
                        'guardian_phone',
                    );
                }
            ])
            ->where('status', 'scheduled')
            ->where('paedagog', true)
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function setScheduledDate(int $observationId, string $date)
    {
        return $this->model->where('observation_id', $observationId)->update([
            'scheduled_date' => $date,
            'status' => 'scheduled'
        ]);
    }
}
