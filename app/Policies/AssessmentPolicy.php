<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    public function verifyAsParent(User $user, Assessment $assessment): bool
    {
        $assessment->loadMissing('child.family.guardians.user');

        $isParent = $assessment->child
            ->family
            ->guardians
            ->pluck('user_id')
            ->contains($user->id);

        if (!$isParent) {
            throw new AuthorizationException(
                'Anda tidak memiliki akses ke asesmen ini karena bukan orang tua dari anak tersebut.'
            );
        }

        return true;
    }

    public function downloadReport(User $user, Assessment $assessment): bool
    {
        if (!$assessment->report_file) {
            throw new AuthorizationException(
                'Laporan asesmen belum tersedia atau belum diunggah.'
            );
        }

        return $this->verifyAsParent($user, $assessment);
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
            ->where(function ($query) use ($user) {
                $query->whereNull('therapist_id')
                    ->orWhere('therapist_id', $user->therapist->id);
            })
            ->first();

        if (!$assessmentDetail) {
            return false;
        }

        return true;
    }
}
