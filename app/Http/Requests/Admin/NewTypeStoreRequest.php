<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewTypeStoreRequest extends FormRequest
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
            'name_type' => ['required', 'string', 'max:255'], // Bắt buộc, dạng chuỗi, tối đa 255 ký tự
            'price' => ['required', 'numeric', 'min:0'], // Bắt buộc, dạng số, không âm
            'status' => ['required', 'in:0,1'], // Chỉ chấp nhận 0 hoặc 1
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name_type.required' => 'Tên loại tin không được để trống.',
            'name_type.string' => 'Tên loại tin phải là chuỗi ký tự.',
            'name_type.max' => 'Tên loại tin không được vượt quá 255 ký tự.',

            'price.required' => 'Giá không được để trống.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không thể nhỏ hơn 0.',

            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái phải là 0 (Ẩn) hoặc 1 (Hiển thị).',
        ];
    }
}
