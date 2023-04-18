<?php

namespace App\Rules;

use App\Utils\Rut;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidRut implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string                                                                $attribute
     * @param mixed                                                                 $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     *
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $rut = Rut::fromString($value);

        if (!$rut->isValid()) {
            $fail('El :attribute ingresado no es válido.');
        }
    }
}
