<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class ArabicNumeric implements Rule
{
    public function passes($attribute, $value)
    {
        // Normalize Arabic numerals to Western numerals
        $westernNumerals = [
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3',
            '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7',
            '٨' => '8', '٩' => '9'
        ];

        $normalizedValue = strtr($value, $westernNumerals);

        // Check if the normalized value is numeric
        return is_numeric($normalizedValue);
    }

    public function message()
    {
        return __('The :attribute must be a valid number.');
    }
}