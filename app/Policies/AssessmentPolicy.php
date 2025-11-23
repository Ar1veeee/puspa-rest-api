<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class AssessmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function view(User $user, AssessmentDetail $assessmentDetail): bool
    {
        $user->loadMissing('guardian');
        $assessmentDetail->loadMissing('assessment.child');

        $userFamilyId = $user->guardian?->family_id;
        $childFamilyId = $assessmentDetail->assessment?->child?->family_id;

        Log::info('Policy markAsComplete check', [
            'assessment_detail_id' => $assessmentDetail->id,
            'assessment_id' => $assessmentDetail->assessment_id,
            'assessment_exists' => $assessmentDetail->assessment ? 'yes' : 'no',
            'child_id' => $assessmentDetail->assessment?->child_id,
            'child_exists' => $assessmentDetail->assessment?->child ? 'yes' : 'no',
        ]);

        return $userFamilyId && $childFamilyId && $userFamilyId === $childFamilyId;
    }

    /**
     *
     * @param \App\Models\User $user
     * @param \App\Models\Assessment $assessment
     * @return bool
     */
    public function storeHistory(User $user, Assessment $assessment): bool
    {
        return $this->view($user, $assessment);
    }
}
