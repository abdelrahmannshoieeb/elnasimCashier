<?php

if (!function_exists('normalize_arabic_numbers')) {
    /**
     * Normalize Arabic numerals to Western numerals.
     *
     * @param string|null $value
     * @return string|null
     */
    function normalize_arabic_numbers(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        $westernNumerals = [
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3',
            '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7',
            '٨' => '8', '٩' => '9'
        ];

        return strtr($value, $westernNumerals);
    }
}
