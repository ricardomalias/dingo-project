<?php

namespace App\feature\company\repository;


use Dingo\Api\Http\FormRequest;

class CompanyConfigurationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'configurations' => 'required|array',
            'configurations.*.key' => 'required|string',
            'configurations.*.value' => 'required|string'
        ];
    }
}