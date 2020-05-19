<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role->id == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:6|max:50',
            'description' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'deadline' => 'required|after:start_time|date',
            'users' => 'required|array',
            'client' => 'required|int',
            'planned_time' => 'required|int'
        ];
    }
}
