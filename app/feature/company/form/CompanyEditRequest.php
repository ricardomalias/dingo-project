<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class CompanyEditRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'document' => 'array',
            'document.*.type' => 'string',
            'document.*.value' => 'string|min:18|max:18',
        ];
    }
}
