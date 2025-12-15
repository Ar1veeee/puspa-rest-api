<?php

namespace App\Actions\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LogoutUserAction
{
    public function execute(): void
    {
        $user = request()->user();

        $user->currentAccessToken()?->delete();
    }
}
