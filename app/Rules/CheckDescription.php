<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * CheckDescription
 */
class CheckDescription implements Rule
{
    private $type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Method passes
     *
     * @param string $attribute 
     * @param string $value     
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $description = strip_tags($value);

        return ! (empty($description));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ('page_content' == $this->type) ? trans('validation.custom.page_content_required') : trans('validation.custom.answer_required');
    }
}
