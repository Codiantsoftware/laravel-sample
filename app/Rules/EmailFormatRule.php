<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;

/**
 * EmailFormatRule
 */
class EmailFormatRule implements Rule
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
        $strictEmail = Config::get('constants.regex_validation.strict_email');
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return preg_match($strictEmail, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.email');
    }
}
