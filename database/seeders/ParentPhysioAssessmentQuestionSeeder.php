<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestionGroup;
use App\Models\AssessmentQuestion;

class ParentPhysioAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $assessmentType = 'parent_fisio';

        $group = AssessmentQuestionGroup::create([
            'assessment_type' => $assessmentType,
            'group_title' => 'Data Fisioterapi',
            'group_key' => 'fisio_data',
            'filled_by' => 'parent',
            'sort_order' => 1
        ]);

        $questions = [
            [
                'code' => 'FISIO-1',
                'text' => 'Keluhan utama yang dialami anak saat ini:',
            ],
            [
                'code' => 'FISIO-2',
                'text' => 'Riwayat penyakit atau kondisi yang berhubungan dengan fisioterapi:',
            ],
        ];

        $number = 1;

        foreach ($questions as $q) {
            AssessmentQuestion::create([
                'group_id' => $group->id,
                'assessment_type' => $assessmentType,
                'section' => 'fisio_data',
                'question_code' => $q['code'],
                'question_number' => $number++,
                'question_text' => $q['text'],
                'answer_type' => 'text',
                'answer_options' => null,
                'extra_schema' => null,
                'is_active' => true,
            ]);
        }
    }
}
