<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChildPolicy
{
    use HandlesAuthorization;

    public function manageChild(User $user, Child $child)
    {
        return $user->guardian->family_id === $child->family_id;
    }
}
