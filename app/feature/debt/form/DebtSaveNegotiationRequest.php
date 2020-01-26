<?php


namespace App\feature\debt\form;


use Dingo\Api\Http\FormRequest;

class DebtSaveNegotiationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'parcel_quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string'
        ];
    }
}