<?php

namespace App\feature\user\form;


use Dingo\Api\Http\FormRequest;

class UserSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }
}