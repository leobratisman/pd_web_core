<?php

namespace App\Rules;

use App\Utils\enums\DateType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateTypeValue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null) {
            return;
        }

        if (!in_array($value, DateType::values())) {
            $fail("The $attribute must be a valid enum value.");
        }
    }
}
