<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'          => ['required', 'email:rfc', 'max:255'],
            'password'       => ['required'],
            'new_password'   => ['required', Password::min(8)->mixedCase()->numbers(), "confirmed"],
            
            //'token'          => ['required']
        ];
    }
}
