<?php

namespace App\Http\Repositories;

use App\Models\ObservationQuestion;
use Illuminate\Database\Eloquent\Collection;

class ObservationQuestionRepository
{
    protected $model;

    public function __construct(ObservationQuestion $model)
    {
        $this->model = $model;
    }

    public function getQuestionsByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getByAgeCategory(string $ageCategory)
    {
        return $this->model
            ->where('age_category', $ageCategory)
            ->orderBy('question_number', 'asc')
            ->get();
    }
}
