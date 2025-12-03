<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueGuardianIdentityNumber implements ValidationRule
{
    protected $familyId;
    protected $currentGuardianId;

    public function __construct($familyId, $currentGuardianId = null)
    {
        $this->familyId = $familyId;
        $this->currentGuardianId = $currentGuardianId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (blank($value)) {
            return;
        }

        $query = DB::table('guardians')
            ->where('guardian_identity_number', $value)
            ->where('family_id', '!=', $this->familyId);

        if ($this->currentGuardianId) {
            $query->where('id', '!=', $this->currentGuardianId);
        }

        if ($query->exists()) {
            $fail('NIK :input sudah digunakan oleh orang tua/wali anak lain.');
        }
    }
}
