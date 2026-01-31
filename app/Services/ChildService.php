<?php

namespace App\Services;

use App\Actions\Admin\CreatePatientAction;
use App\Actions\Child\UpdateChildWithFamilyAction;
use App\Models\Child;
use Illuminate\Support\Collection;

class ChildService
{
    public function __construct(
        private UpdateChildWithFamilyAction $updateChildWithFamilyAction,
        private CreatePatientAction $createPatientAction,
    ) {}

    public function getAllChild(): Collection
    {
        return Child::with('family.guardians.user')->get();
    }

    public function store(array $data): Child
    {
        return $this->createPatientAction->execute($data);
    }

    public function update(array $data, Child $child): Child
    {
        return $this->updateChildWithFamilyAction->execute($child, $data);
    }

    public function destroy(Child $child): bool
    {
        return $child->delete();
    }
}
