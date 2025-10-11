<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ObservationCompleted implements Rule
{
    public function passes($attribute, $value)
    {
        return DB::table('guardians')
            ->join('families', 'guardians.family_id', '=', 'families.id')
            ->join('children', 'families.id', '=', 'children.family_id')
            ->join('observations', 'children.id', '=', 'observations.child_id')
            ->where('guardians.temp_email', $value)
            ->where('observations.is_continued_to_assessment', true)
            ->where('observations.status', 'Completed')
            ->exists();
    }

    public function message()
    {
        return 'Observasi Anda belum disetujui atau belum selesai. Silakan hubungi terapis untuk informasi lebih lanjut.';
    }
}
