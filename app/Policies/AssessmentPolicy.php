<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    public function viewAssessment(User $user, Assessment $assessment): bool
    {
        if ($user->hasAnyRole(['admin', 'asesor'])) {
            return true;
        }

        if ($user->hasRole('user') && $user->guardian) {
            return $user->guardian->family_id === $assessment->child->family_id;
        }

        return false;
    }

    public function downloadReport(User $user, Assessment $assessment): bool
    {
        return $assessment->report_file !== null && $this->viewAssessment($user, $assessment);
    }

    public function fillAssessor(User $user, Assessment $assessment, string $type): bool
    {
        if (! $user->hasRole('asesor') || ! $user->therapist) {
            return false;
        }

        $typeToSection = [
            'okupasi_assessor' => 'okupasi',
            'fisio_assessor' => 'fisio',
            'wicara_assessor' => 'wicara',
            'paedagog_assessor' => 'paedagog',
        ];

        $requiredSection = $typeToSection[$type] ?? null;

        if (!$requiredSection) {
            return false;
        }

        if ($user->therapist->therapist_section !== $requiredSection) {
            return false;
        }

        $assessmentDetail = $assessment->assessmentDetails()
            ->where('type', $requiredSection)
            ->first();

        if (!$assessmentDetail) {
            return false;
        }

        return true;
    }
}
