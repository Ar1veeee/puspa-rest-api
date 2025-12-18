<?php

namespace App\Services;

use App\Actions\Therapist\CreateTherapistAction;
use App\Actions\Therapist\DeleteTherapistAction;
use App\Actions\Therapist\UpdateProfileTherapistAction;
use App\Actions\Therapist\UpdateTherapistAction;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Collection;

class TherapistService
{
    public function index(): Collection
    {
        return Therapist::with('user:id,username,email,is_active')
            ->whereHas('user', fn($q) => $q->where('is_active', true))
            ->latest()
            ->get();
    }

    public function show(Therapist $therapist): Therapist
    {
        return $therapist->load('user:id,username,email,is_active');
    }

    public function store(array $data): Therapist
    {
        return (new CreateTherapistAction)->execute($data);
    }

    public function update(array $data, Therapist $therapist): Therapist
    {
        return (new UpdateTherapistAction)->execute($therapist, $data);
    }

    public function updateProfile(array $data, Therapist $therapist): Therapist
    {
        return (new UpdateProfileTherapistAction)->execute($therapist, $data);
    }

    public function destroy(Therapist $therapist): void
    {
        (new DeleteTherapistAction)->execute($therapist);
    }

    public function getProfile(string $userId): Therapist
    {
        return Therapist::with('user')->where('user_id', $userId)->firstOrFail();
    }
}
