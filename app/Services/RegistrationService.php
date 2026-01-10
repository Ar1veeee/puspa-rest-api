<?php

namespace App\Services;

use App\Actions\Registration\RegisterFamilyAction;
use App\Models\Child;

class RegistrationService
{
    public function __construct(
        private RegisterFamilyAction $registerFamilyAction
    ) {}

    public function registration(array $data): Child
    {
        return $this->registerFamilyAction->execute($data);
    }
}
