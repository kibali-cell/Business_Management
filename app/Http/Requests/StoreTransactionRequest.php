<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'type' => 'required|in:income,expense,transfer',
            'amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $fromAccount = Account::find($this->from_account_id);
                    if ($fromAccount && $value > $fromAccount->balance) {
                        $fail('Insufficient funds in the source account.');
                    }
                },
            ],
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id|different:from_account_id',
            'transaction_date' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:500'
        ];
    }
}
