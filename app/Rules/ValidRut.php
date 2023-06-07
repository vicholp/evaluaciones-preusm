<?php

namespace App\Rules;

use App\Utils\Rut;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRut implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, mixed $fail): void
    {
        $rut = Rut::fromString($value);

        if (!$rut->isValid()) {
            $fail('El :attribute ingresado no es válido.');
        }
    }
}
