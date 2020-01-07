<?php


namespace App\feature\CustomerList\form;

use Dingo\Api\Http\FormRequest;

class CustomerListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required',
            'name' => 'required'
        ];
    }
}
