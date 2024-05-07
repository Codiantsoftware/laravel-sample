<?php

namespace App\Http\Requests\Frontend;

use App\Rules\EmailFormatRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        // Define validation rules
        return [
            'email' => ['required', new EmailFormatRule()],
            'password' => 'required',
            'remember' => '', // Not specified in the rules
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        // Define custom error messages for validation rules
        return [
            'email.required' => trans('validation.required', ['attribute' => 'Email']),
            'password.required' => trans('validation.required', ['attribute' => 'Password']),
        ];
    }
}
