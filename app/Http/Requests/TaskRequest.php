<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
            'start_date'         => ['date_format:Y-m-d', 'after_or_equal:today'],
            'end_date'           => ['nullable','date_format:Y-m-d', 'after_or_equal:start_date'],
            'start_time'         => ['after_or_equal:now'],
            'end_time'           => ['nullable', 'after_or_equal:start_time'],
            'confirmation'       => ['nullable', 'boolean'],
        ];
    }
}
