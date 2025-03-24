<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepliesRequest extends FormRequest
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
            'reply_content' => 'required|string|max:1000'
        ];
    }

    public function messages(): array {
        return [
            'reply_content.required' => 'Vui lòng nhập nội dung bình luận.',
            'reply_content.string' => 'Nội dung bình luận phải là chuỗi ký tự.',
            'reply_content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
        ];
    }
}
