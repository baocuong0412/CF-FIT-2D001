<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng gửi yêu cầu
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:10',
            'email' => 'required|email|max:255',
            'problem' => 'required|in:1,2,3,4',
            'message' => 'required|string|min:10|max:1000',
        ];
    }

    /**
     * Custom messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Nội dung phải có ít nhất 10 ký tự.',
            'phone.max' => 'Nội dung không được vượt quá 10 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'problem.required' => 'Vui lòng chọn loại vấn đề cần giải quyết.',
            'problem.in' => 'Loại vấn đề không hợp lệ.',

            'message.required' => 'Vui lòng nhập nội dung.',
            'message.string' => 'Nội dung phải là chuỗi ký tự.',
            'message.min' => 'Nội dung phải có ít nhất 10 ký tự.',
            'message.max' => 'Nội dung không được vượt quá 1000 ký tự.',
        ];
    }
}
