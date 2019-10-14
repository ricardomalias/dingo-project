<?php


namespace App\feature\customer\form;

use Dingo\Api\Http\FormRequest;

class CustomerSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_id' => 'required|string',
            'name' => 'required|string',
            'documents' => 'required|array',
            'documents.*.type' => 'required|string',
            'documents.*.value' => 'required|string',
            'addresses' => 'required|array',
        ];
    }
}
