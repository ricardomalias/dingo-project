<?php


namespace App\feature\debt\form;


use Dingo\Api\Http\FormRequest;

class DebtSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'parcel_quantity' => 'required|integer|min:0',
            'discounts' => 'array'
        ];
    }
}