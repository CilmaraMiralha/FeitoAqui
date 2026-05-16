<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CPF implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('O :attribute informado é inválido.');
            return;
        }

        $cpf = preg_replace('/\D/', '', $value) ?? '';

        if (strlen($cpf) !== 11) {
            $fail('O :attribute deve conter 11 dígitos.');
            return;
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            $fail('O :attribute informado é inválido.');
            return;
        }

        $digits = array_map('intval', str_split($cpf));

        $firstDigit = 0;
        for ($i = 0; $i < 9; $i++) {
            $firstDigit += $digits[$i] * (10 - $i);
        }
        $firstDigit = ($firstDigit * 10) % 11;
        $firstDigit = $firstDigit === 10 ? 0 : $firstDigit;

        $secondDigit = 0;
        for ($i = 0; $i < 10; $i++) {
            $secondDigit += $digits[$i] * (11 - $i);
        }
        $secondDigit = ($secondDigit * 10) % 11;
        $secondDigit = $secondDigit === 10 ? 0 : $secondDigit;

        if ($digits[9] !== $firstDigit || $digits[10] !== $secondDigit) {
            $fail('O :attribute informado é inválido.');
        }
    }
}
