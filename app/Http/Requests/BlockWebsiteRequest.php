<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockWebsiteRequest extends FormRequest
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
            //
            'website_link'     => ['required', 'string', 'max:255'],
            'website_name'     => ['required', 'string', 'max:255'],
            'is_include'       => ['sometimes', 'boolean'],
        ];
    }
}
