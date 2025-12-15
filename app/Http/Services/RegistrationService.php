<?php

namespace App\Http\Services;

use App\Actions\Registration\RegisterFamilyAction;
use App\Models\Child;

class RegistrationService
{
    public function registration(array $data): Child
    {
        return (new RegisterFamilyAction)->execute($data);
    }
}
