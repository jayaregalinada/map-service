<?php

namespace App\Http\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class Coordinates implements Rule
{
    private const SEPARATOR = ',';

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        return Str::contains($value, self::SEPARATOR) && (count(explode(self::SEPARATOR, $value)) === 2);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return __('validation.invalid_coordinates');
    }
}
