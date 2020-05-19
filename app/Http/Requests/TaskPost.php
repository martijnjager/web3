<?php

namespace App\Http\Requests;

use App\Moscow;
use App\Role;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class TaskPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role->id <= Role::DEVELOPER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:50|min:4',
            'description' => 'required|string|max:255',
            'comment' => 'nullable|string|max:255',
            'user_id' => 'required|int|between:1,' . (new User())->get()->count(),
            'moscow_id' => 'required|int|between:1,' . (new Moscow())->get()->count(),
            'planned_time' => 'required|int|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'enter a title for the task',
            'description.required' => 'provide a description for the task',
            'user_id.required' => 'select a user to do this task',
            'planned_time.required' => 'provide the number of hours you expect to spend on this task'
        ];
    }
}
