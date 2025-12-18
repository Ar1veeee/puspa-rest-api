<?php

namespace App\Http\Services;

use App\Actions\Guardian\AddChildAction;
use App\Actions\Guardian\UpdateFamilyGuardiansAction;
use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Support\Arr;

class GuardianService
{
    public function getProfile(string $userId): Guardian
    {
        return Guardian::with('user')->where('user_id', $userId)->firstOrFail();
    }

    public function addChild(Guardian $guardian, array $data): Child
    {
        return (new AddChildAction)->execute($guardian, $data);
    }

    public function updateFamilyGuardians(Guardian $primaryGuardian, array $data): void
    {
        (new UpdateFamilyGuardiansAction)->execute($primaryGuardian, $data);
    }


    public function updateProfile(Guardian $guardian, array $data)
    {
        $guardian->user->update(Arr::only($data, ['email']));
        $guardian->update(Arr::except($data, ['email']));
        return $guardian->fresh()->load('user');
    }
}
