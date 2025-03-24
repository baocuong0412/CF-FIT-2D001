<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewStoreRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'image_new' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề bài đăng.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'image_new.image' => 'Tệp phải là hình ảnh.',
            'description.required' => 'Vui lòng nhập nội dung bài đăng.',
        ];
    }
}
