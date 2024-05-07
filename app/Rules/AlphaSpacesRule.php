<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * AlphaSpacesRule
 */
class AlphaSpacesRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute [attribute]
     * @param mixed  $value     [Value]
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[\pL\s]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.name.alpha_spaces');
    }
}
