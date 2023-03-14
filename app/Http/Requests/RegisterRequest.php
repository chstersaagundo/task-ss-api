<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //set to true everytime when making a request form to be recognize as authorized sheesh
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'firstname'      => ['required', 'string', 'max:100'],
            'lastname'       => ['required', 'string', 'max:100'],
            'password'       => ['required', Password::min(8)->mixedCase()->numbers(), "confirmed"],
            'email'          => ['required', 'email:rfc', 'max:255', "unique:users,email"],
            'phone'          => ['required', 'string', 'max:20']
        ];
    }
}
