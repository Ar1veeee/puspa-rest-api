<?php

namespace App\Services;

use App\Actions\Child\UpdateChildWithFamilyAction;
use App\Models\Child;
use Illuminate\Support\Collection;

class ChildService
{
    public function getAllChild(): Collection
    {
        return Child::with('family.guardians')->get();
    }

    public function update(array $data, Child $child): Child
    {
        return app(UpdateChildWithFamilyAction::class)->execute($child, $data);
    }

    public function destroy(Child $child): bool
    {
        return $child->delete();
    }
}
