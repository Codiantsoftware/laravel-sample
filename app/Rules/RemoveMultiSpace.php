<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;

/**
 * RemoveMultiSpace
 */
class RemoveMultiSpace implements Rule
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

        $multiSpace = Config::get('constants.regex_validation.multi_space');

        return ! (preg_match($multiSpace, $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.single_space');
    }
}
