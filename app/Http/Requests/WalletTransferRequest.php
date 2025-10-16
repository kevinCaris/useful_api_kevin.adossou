<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletTransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['auth_id' => auth()->id()]);
    }
    public function rules()
    {
        return [
            'receiver_id' => 'required|exists:users,id|different:auth_id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }

}
