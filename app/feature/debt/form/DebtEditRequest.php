<?php

namespace App\feature\debt\form;

use Dingo\Api\Http\FormRequest;

class DebtEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'numeric|min:0',
            'parcel_quantity' => 'integer|min:0',
            'due_date' => 'date'
        ];
    }
}