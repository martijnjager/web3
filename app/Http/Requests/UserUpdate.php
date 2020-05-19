<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PasswordRule;

class UserUpdate extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:25',
            'email' => 'required|email',
            'role_id' => 'digits_between:1,' . (new Role())->get()->count(),
            'password' => [
                'nullable',
                'min:8',
                'sometimes',
                'confirmed',
            ],
            'profile_image' => 'image||nullable'
        ];
    }
}
