<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class DepositMoneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pay_price' => ['required', 'numeric', 'min:50000']
        ];
    }

    public function messages()
    {
        return [
            'pay_price.required' => 'Vui lòng nhập số tiền cần nạp.',
            'pay_price.numeric' => 'Số tiền phải là một số hợp lệ.',
            'pay_price.min' => 'Số tiền nạp phải lớn hơn hoặc bằng 50,000 đồng.',
        ];
    }
}
