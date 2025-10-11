<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function view(User $user, Assessment $assessment): bool
    {
        return $user->guardian?->family_id === $assessment->child?->family_id;
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
