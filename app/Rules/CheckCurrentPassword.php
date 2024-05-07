<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 * CheckCurrentPassword
 */
class CheckCurrentPassword implements Rule
{
    /**
     * Method passes
     *
     * @param $attribute $attribute
     * @param $value     $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $returnData = false;
        $post = request()->all();
        $user = User::findOrFail(auth()->user()->id);
        // Check if current user password is equal to password provided by user
        if (! empty($user) && (Hash::check($post['current_password'], $user->password))) {
            $returnData = true;
        }

        return $returnData;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.incorrect_current_password');
    }
}
