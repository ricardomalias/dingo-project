<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class CompanySaveRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'document' => 'required|array',
            'document.*.type' => 'required|string',
            'document.*.value' => 'required|string|min:18|max:18',
        ];
    }
}
