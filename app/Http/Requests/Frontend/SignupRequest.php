<?php

namespace App\Http\Requests\Frontend;

use App\Rules\AlphaSpacesRule;
use App\Rules\RemoveSpace;
use App\Rules\RemoveMultiSpace;
use App\Rules\EmailFormatRule;
use App\Rules\WithoutSpacesRule;
use App\Rules\StrictPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to make this request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:5',
                'max:20',
                new RemoveMultiSpace,
                new RemoveSpace,
                new AlphaSpacesRule
            ],
            'email' => [
                'required',
                new EmailFormatRule,
                'max:50',
                'unique:users,email,'.$this->id.',id,deleted_at,NULL',
                new RemoveSpace
            ],
            'phone_number' => [
                'required',
                'digits_between:10,12',
                'unique:users,phone_number,'.$this->id.',id,deleted_at,NULL'
            ],
            'password'=> [
                'required',
                'confirmed',
                new WithoutSpacesRule(),
                new StrictPasswordRule()
            ]
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => 'Full Name']),
            'email.required' => trans('validation.required', ['attribute' => 'Email']),
            'username.required' => trans('validation.required', ['attribute' => 'Username']),
            'phone_number.required' => trans('validation.required', ['attribute' => 'Phone Number']),
            'password.required' => trans('validation.required', ['attribute' => 'Password']),
            'password.regex' => trans('validation.password.password_regex'),
            'password.confirmed' => trans('validation.password.confirm')
        ];
    }
}
