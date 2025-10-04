<?php

namespace App\Http\Repositories;

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

    public function hasObservationContinuedToAssessment(string $email)
    {
        return DB::table('guardians')
            ->join('families', 'guardians.family_id', '=', 'families.id')
            ->join('children', 'families.id', '=', 'children.family_id')
            ->join('observations', 'children.id', '=', 'observations.child_id')
            ->where('guardians.temp_email', $email)
            ->where('observations.is_continued_to_assessment', true)
            ->where('observations.status', 'Completed')
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

    public function removeTempEmail(string $userId)
    {
        return $this->model->where('user_id', $userId)->update(['temp_email' => null]);
    }
}
