<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidSku implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validar que el SKU tenga un formato específico (por ejemplo, "PROD1234")
        if (!preg_match('/^PROD\d{4}$/', $value)) {
            $fail('El SKU debe tener el formato "PROD1234".');
        }
    }
}
