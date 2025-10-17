<?php

namespace App\Http\Repositories;

use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Support\Facades\DB;

class GuardianRepository
{
    protected $model;

    public function __construct(Guardian $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findByUserId(string $userId)
    {
        return $this->model
            ->with('user')
            ->where('user_id', $userId)
            ->first();
    }

    public function findByFamilyIdAndType(string $familyId, string $type)
    {
        return $this->model->where('family_id', $familyId)->where('guardian_type', $type)->first();
    }

    public function getChildrenByUserId(string $userId)
    {
        $guardian = $this->model
            ->with('family.children')
            ->where('user_id', $userId)
            ->firstOrFail();
        return $guardian->family->children;
    }

    public function getAssessments(string $userId)
    {
        $guardian = $this->model->where('user_id', $userId)->first();
        if (!$guardian) {
            return collect();
        }

        return Child::with([
            'assessment' => function ($query) {
                $query->select(
                    'id',
                    'child_id',
                    'scheduled_date',
                    'status',
                    'created_at',
                    'updated_at',
                )
                    ->orderBy('scheduled_date', 'asc');
            }
        ])
            ->select(
                'id',
                'family_id',
                'child_name',
                'child_gender',
                'child_school',
                'child_birth_date',
                'child_birth_place'
            )
            ->where('family_id', $guardian->family_id)
            ->whereHas('assessment', function ($query) {
                $query->where('status', 'scheduled');
            })
            ->get();
    }

    public function hasObservationContinuedToAssessment(string $email)
    {
        return $this->model
            ->where('temp_email', $email)
            ->whereHas('family.children.observations', function ($query) {
                $query->where('is_continued_to_assessment', true)
                    ->where('status', 'completed');
            })
            ->exists();
    }

    public function checkExistingEmail(string $email): bool
    {
        return $this->model->where('temp_email', $email)->exists();
    }

    public function updateUserIdByEmail(string $email, string $userId)
    {
        return $this->model->where('temp_email', $email)->update(['user_id' => $userId]);
    }

    public function update(array $data, string $id): bool
    {
        $guardian = $this->model->find($id);
        if ($guardian) {
            return $guardian->update($data);
        }
        return false;
    }

    public function removeTempEmail(string $userId)
    {
        return $this->model->where('user_id', $userId)->update(['temp_email' => null]);
    }
}
