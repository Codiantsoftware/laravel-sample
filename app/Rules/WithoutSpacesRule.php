<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * WithoutSpacesRule
 */
class WithoutSpacesRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param $attribute string
     * @param $value     mixed
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^\S*$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.password.remove_space');
    }
}
