<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'category_id'       => ['sometimes'],
            'task_type_id'       => ['sometimes'],
            'task_name'          => ['required', 'string', 'max:100'],
            'task_desc'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'is_starred'         => ['sometimes', 'boolean'],
            'priority'           => ['required', 'string'],
            'status'             => ['required', 'string'],
            'start_date'         => ['date_format:Y-m-d'],
            'end_date'           => ['date_format:Y-m-d'],
            'start_time'         => ['date_format:H:i:s'],
            'end_time'           => ['date_format:H:i:s'],
        ];
    }
}
