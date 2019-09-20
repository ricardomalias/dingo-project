<?php


namespace App\feature\customer\form;


use Dingo\Api\Http\FormRequest;

class CustomerEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'documents' => 'array',
            'documents.*.type' => 'string',
            'documents.*.value' => 'string',
            'addresses' => 'array',
        ];
    }
}
