<?php

namespace App\Actions\Therapist;

use App\Models\Therapist;
use Illuminate\Support\Facades\DB;

class DeleteTherapistAction
{
    public function execute(Therapist $therapist): void
    {
        DB::transaction(function () use ($therapist) {
            $therapist->user()->delete();
            $therapist->delete();
        });
    }
}