<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    private $rules = [
        'name' => 'string'
    ];

    public function rules()
    {
        return $this->rules;
//        return Config::get('form.company.validation_rules');
        // return Config::get('boilerplate.login.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
