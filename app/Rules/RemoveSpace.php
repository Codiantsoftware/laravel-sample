<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * RemoveSpace
 */
class RemoveSpace implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute 
     * @param mixed  $value 
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! ('' == trim($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.remove_space');
    }
}
