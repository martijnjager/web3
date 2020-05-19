<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserPost extends FormRequest
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
            'role_id' => 'required|digits_between:1,' . (new Role())->get()->count(),
            'password' => 'min:8|required|confirmed',
            'profile_image' => 'image||nullable'
        ];
    }
}
